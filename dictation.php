<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voice Dictation</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }
        .header {
            padding: 28px;
            color: white;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .header h1 { margin: 0 0 8px; }
        .header p { margin: 0; opacity: 0.9; }
        .content { padding: 28px; }
        .toolbar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        select, button {
            min-height: 44px;
            border-radius: 10px;
            font: inherit;
        }
        select {
            flex: 1;
            min-width: 180px;
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            background: white;
        }
        button {
            border: none;
            padding: 10px 16px;
            cursor: pointer;
            font-weight: 600;
            color: white;
            background: #667eea;
        }
        button:disabled { cursor: not-allowed; opacity: 0.55; }
        #dictateButton.recording {
            background: #dc3545;
            box-shadow: 0 0 0 6px rgba(220, 53, 69, 0.12);
        }
        #text {
            width: 100%;
            min-height: 360px;
            resize: vertical;
            padding: 18px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font: 18px/1.6 "Segoe UI", Tahoma, sans-serif;
            outline: none;
        }
        #text:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .status {
            min-height: 24px;
            margin: 12px 0 8px;
            color: #555;
            font-size: 14px;
        }
        .secondary { background: #6c757d; }
        .success { background: #198754; }
        .back {
            display: inline-block;
            margin-bottom: 18px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        @media (max-width: 600px) {
            body { padding: 8px; }
            .container { margin: 8px auto; }
            .content { padding: 18px; }
            #text { min-height: 300px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎙️ Voice Dictation</h1>
            <p>Speak naturally and convert your voice into editable text</p>
        </div>
        <div class="content">
            <a class="back" href="<?= isset($_SESSION['pid']) ? 'dashboard.php' : 'index.php' ?>">← Back</a>
            <div class="toolbar">
                <select id="language" aria-label="Dictation language">
                    <option value="en-US">English (United States)</option>
                    <option value="en-IN">English (India)</option>
                    <option value="hi-IN">Hindi (India)</option>
                    <option value="ta-IN">Tamil (India)</option>
                    <option value="te-IN">Telugu (India)</option>
                    <option value="es-ES">Spanish (Spain)</option>
                    <option value="fr-FR">French (France)</option>
                </select>
                <button id="dictateButton" type="button">Start dictation</button>
                <button id="copyButton" class="success" type="button">Copy</button>
                <button id="downloadButton" class="secondary" type="button">Download</button>
                <button id="clearButton" class="secondary" type="button">Clear</button>
            </div>
            <div id="status" class="status" role="status" aria-live="polite"></div>
            <textarea id="text" aria-label="Dictated text" placeholder="Your text will appear here..."></textarea>
        </div>
    </div>

    <script>
        const Recognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const dictateButton = document.getElementById('dictateButton');
        const copyButton = document.getElementById('copyButton');
        const downloadButton = document.getElementById('downloadButton');
        const clearButton = document.getElementById('clearButton');
        const languageSelect = document.getElementById('language');
        const textArea = document.getElementById('text');
        const status = document.getElementById('status');
        let recognition = null;
        let isListening = false;
        let finalText = textArea.value;

        function setStatus(message) {
            status.textContent = message;
        }

        if (!window.isSecureContext) {
            dictateButton.disabled = true;
            setStatus('Microphone dictation requires HTTPS or localhost.');
        } else if (!Recognition) {
            dictateButton.disabled = true;
            setStatus('Voice dictation is not supported by this browser.');
        } else {
            recognition = new Recognition();
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = languageSelect.value;

            recognition.onstart = function() {
                isListening = true;
                dictateButton.textContent = 'Stop dictation';
                dictateButton.classList.add('recording');
                setStatus('Listening... Speak now.');
            };

            recognition.onresult = function(event) {
                let interimText = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const transcript = event.results[i][0].transcript;
                    if (event.results[i].isFinal) {
                        finalText += (finalText && !/\s$/.test(finalText) ? ' ' : '') + transcript.trim();
                    } else {
                        interimText += transcript;
                    }
                }
                textArea.value = finalText + (interimText ? ' ' + interimText : '');
            };

            recognition.onerror = function(event) {
                setStatus('Dictation error: ' + event.error);
            };

            recognition.onend = function() {
                isListening = false;
                dictateButton.textContent = 'Start dictation';
                dictateButton.classList.remove('recording');
                if (!status.textContent.startsWith('Dictation error')) {
                    setStatus('Dictation stopped.');
                }
            };

            dictateButton.addEventListener('click', function() {
                if (isListening) {
                    recognition.stop();
                    return;
                }
                finalText = textArea.value;
                recognition.lang = languageSelect.value;
                try {
                    recognition.start();
                } catch (error) {
                    setStatus('Unable to start dictation: ' + error.message);
                }
            });

            languageSelect.addEventListener('change', function() {
                recognition.lang = languageSelect.value;
            });
        }

        copyButton.addEventListener('click', async function() {
            if (!textArea.value) {
                setStatus('There is no text to copy.');
                return;
            }
            try {
                await navigator.clipboard.writeText(textArea.value);
                setStatus('Text copied to clipboard.');
            } catch (error) {
                textArea.select();
                document.execCommand('copy');
                setStatus('Text copied to clipboard.');
            }
        });

        downloadButton.addEventListener('click', function() {
            if (!textArea.value) {
                setStatus('There is no text to download.');
                return;
            }
            const blob = new Blob([textArea.value], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'dictation-' + new Date().toISOString().slice(0, 10) + '.txt';
            link.click();
            URL.revokeObjectURL(url);
            setStatus('Text file downloaded.');
        });

        clearButton.addEventListener('click', function() {
            if (isListening) recognition.stop();
            finalText = '';
            textArea.value = '';
            setStatus('Text cleared.');
            textArea.focus();
        });

        textArea.addEventListener('input', function() {
            finalText = textArea.value;
        });
    </script>
</body>
</html>
