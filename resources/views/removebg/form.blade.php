<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Remover | Professional Image Processing</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
            --error: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .tagline {
            color: var(--gray);
            font-size: 1.1rem;
        }

        .upload-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2.5rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .upload-area {
            border: 2px dashed var(--gray);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .upload-text {
            margin-bottom: 0.5rem;
        }

        .file-input {
            display: none;
        }

        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn:hover {
            background: #3a56d4;
            transform: translateY(-2px);
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .file-info {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: var(--gray);
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-error {
            background: #fee2e2;
            color: var(--error);
            border-left: 4px solid var(--error);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .feature {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .feature-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            color: var(--gray);
            font-size: 0.9rem;
        }

        footer {
            text-align: center;
            margin-top: 4rem;
            color: var(--gray);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }

            .upload-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">BG Remover Pro</div>
            <div class="tagline">Remove backgrounds from your images instantly with AI</div>
        </header>

        <div class="upload-card">
            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <h2 class="card-title">Upload Your Image</h2>

            <form action="{{ route('remove.bg') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf

                <label for="image">
                    <div class="upload-area" id="uploadArea">
                        <div class="upload-icon">📁</div>
                        <div class="upload-text">Drag & drop your image here</div>
                    </div>
                </label>
                <input type="file" name="image" id="image" class="file-input" required accept="image/*">

                <div id="fileInfo" class="file-info"></div>

                <button type="submit" class="btn btn-block">
                    Remove Background
                </button>
            </form>
        </div>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">⚡</div>
                <h3 class="feature-title">Instant Processing</h3>
                <p class="feature-desc">Get your background-free images in seconds with our powerful AI technology.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">🛡️</div>
                <h3 class="feature-title">Secure Processing</h3>
                <p class="feature-desc">Your images are processed securely and never stored permanently on our servers.</p>
            </div>

            <div class="feature">
                <div class="feature-icon">🎨</div>
                <h3 class="feature-title">High Quality</h3>
                <p class="feature-desc">Crisp, clean results with transparent backgrounds ready for any use.</p>
            </div>
        </div>

        <footer>
            &copy; 2023 BG Remover Pro. All rights reserved.
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image');
            const uploadArea = document.getElementById('uploadArea');
            const fileInfo = document.getElementById('fileInfo');

            // Handle click on upload area
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });

            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length) {
                    const fileName = e.target.files[0].name;
                    const fileSize = (e.target.files[0].size / (1024 * 1024)).toFixed(2); // in MB

                    fileInfo.textContent = `Selected: ${fileName} (${fileSize} MB)`;
                    fileInfo.style.color = '#4361ee';

                    // Update upload area appearance
                    uploadArea.innerHTML = `
                        <div class="upload-icon">✅</div>
                        <div class="upload-text">${fileName}</div>
                        <div>${fileSize} MB</div>
                    `;
                    uploadArea.style.borderColor = '#4361ee';
                    uploadArea.style.backgroundColor = '#eef2ff';
                }
            });

            // Handle drag and drop
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.style.borderColor = '#4361ee';
                uploadArea.style.backgroundColor = '#eef2ff';
            });

            uploadArea.addEventListener('dragleave', function() {
                uploadArea.style.borderColor = '#94a3b8';
                uploadArea.style.backgroundColor = 'transparent';
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.style.borderColor = '#94a3b8';
                uploadArea.style.backgroundColor = 'transparent';

                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    fileInput.dispatchEvent(event);
                }
            });
        });
    </script>
</body>
</html>
