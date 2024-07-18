<!DOCTYPE html>
<html>

<head>
    <title>Test Multi Upload Files</title>
    <style>

    </style>
    <link rel="stylesheet" type="text/css" href="style-multiupload.css" />
</head>

<body>
    <div class="ath_container tile-container ">
        <div id="uploadStatus"></div>
        <h2 style="margin-bottom:10px">Testing Multi Upload Files - Untuk Semua Format</h2>
        <input type="file" id="fileUpload" multiple placeholder="choose file or browse" /> <!-- Add 'multiple' attribute for multiple file selection -->
        <br>
        <br>
        <button onclick="uploadFiles()">Upload</button> <!-- Change function name -->
        
        <div>
            <table id="progressBarsContainer">
                <!-- Table rows will be dynamically added here -->
            </table>
        </div> <!-- Container for progress bars -->
        <br>
    </div>

    <script>
        function uploadFiles() {
            var fileInput = document.getElementById('fileUpload');
            var files = fileInput.files;

            for (var i = 0; i < files.length; i++) 
            {
                var allowedExtensions = ['.mp4' ,'.jpg', '.jpeg', '.png', '.pdf', '.svg', '.zip', '.docx', '.xlsx'];
                var fileExtension = files[i].name.substring(files[i].name.lastIndexOf('.')).toLowerCase();

                if (allowedExtensions.includes(fileExtension)) 
                {
                    uploadFile(files[i]);
                } 
                else 
                {
                    alert('Invalid file type: ' + fileExtension);
                }
            }
        }

        function uploadFile(file) 
        {
            var formData = new FormData();
            formData.append('file', file);

            var progressBarContainer = document.createElement('div'); // Container for progress bar and file name
            progressBarContainer.className = 'progress-container';

            var fileName = document.createElement('div'); // Display file name
            fileName.className = 'file-name';
            fileName.textContent = file.name;
            //progressBarContainer.appendChild(fileName);

            var progressBar = document.createElement('div'); // Create a new progress bar element
            progressBar.className = 'progress-bar';
            progressBar.id = 'progressBar_' + file.name;

            progressBarContainer.appendChild(progressBar);

            var progressBarsContainer = document.getElementById('progressBarsContainer');

            var newRow = document.createElement('tr'); // Create a new table row
            var newCell = document.createElement('td'); // Create a new table cell
            var newCell2 = document.createElement('td'); // Create a new table cell
            newCell.appendChild(fileName);
            newCell2.appendChild(progressBarContainer);
            newRow.appendChild(newCell);
            newRow.appendChild(newCell2);
            progressBarsContainer.appendChild(newRow);

            var xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(event) 
            {
                if (event.lengthComputable) 
                {
                    var percent = Math.round((event.loaded / event.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressBar.innerHTML = percent + '%';
                }
            });

            xhr.addEventListener('load', function(event) 
            {
                var uploadStatus = document.getElementById('uploadStatus');
                uploadStatus.innerHTML = event.target.responseText;
                // Reset the input field of type "file"
                document.getElementById('fileUpload').value = '';

            });

            xhr.open('POST', 'upload.php', true);
            xhr.send(formData);
        }
    </script>

</body>
</html>