document.addEventListener('DOMContentLoaded', () => {
    // DOM elements
    const startScreen = document.getElementById('start-screen');
    const cameraScreen = document.getElementById('camera-screen');
    const previewScreen = document.getElementById('preview-screen');
    const video = document.getElementById('video');
    const capturedImage = document.getElementById('captured-image');
    const flash = document.getElementById('flash');
    
    // Buttons
    const openCameraBtn = document.getElementById('open-camera-btn');
    const captureBtn = document.getElementById('capture-btn');
    const closeCameraBtn = document.getElementById('close-camera-btn');
    const saveBtn = document.getElementById('save-btn');
    const downloadBtn = document.getElementById('download-btn');
    const retakeBtn = document.getElementById('retake-btn');
    
    // Stream reference
    let stream = null;
    
    // Create hidden canvas for capturing
    const canvas = document.createElement('canvas');
    canvas.style.display = 'none';
    document.body.appendChild(canvas);
    
    // Open camera
    openCameraBtn.addEventListener('click', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'environment',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }, 
                audio: false 
            });
            
            video.srcObject = stream;
            
            // Show camera screen
            startScreen.classList.add('hidden');
            cameraScreen.classList.remove('hidden');
            previewScreen.classList.add('hidden');
            
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Could not access camera. Please check permissions.');
        }
    });
    
    // Capture image
    captureBtn.addEventListener('click', () => {
        // Flash effect
        flash.classList.add('flash-animation');
        setTimeout(() => {
            flash.classList.remove('flash-animation');
        }, 300);
        
        // Set canvas dimensions to match video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw video frame to canvas
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Convert to image data URL
        const imageDataURL = canvas.toDataURL('image/png');
        capturedImage.src = imageDataURL;
        
        // Close camera
        closeCamera();
        
        // Show preview screen
        startScreen.classList.add('hidden');
        cameraScreen.classList.add('hidden');
        previewScreen.classList.remove('hidden');
    });
    
    // Close camera
    closeCameraBtn.addEventListener('click', () => {
        closeCamera();
        
        // Show start screen
        startScreen.classList.remove('hidden');
        cameraScreen.classList.add('hidden');
        previewScreen.classList.add('hidden');
    });
    
    // Save image
    saveBtn.addEventListener('click', async () => {
        try {
            const imageData = capturedImage.src;
            
            // Create form data
            const formData = new FormData();
            formData.append('imageData', imageData);
            
            // Show saving indicator
            saveBtn.disabled = true;
            saveBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            `;
            
            // Send to server
            const response = await fetch('save-image.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            // Reset button
            saveBtn.disabled = false;
            saveBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save
            `;
            
            if (result.success) {
                alert(`Image saved successfully as ${result.filename}`);
                
                // Return to start screen
                startScreen.classList.remove('hidden');
                cameraScreen.classList.add('hidden');
                previewScreen.classList.add('hidden');
            } else {
                throw new Error(result.error || 'Failed to save image');
            }
            
        } catch (error) {
            console.error('Error saving image:', error);
            alert('Failed to save image. Please try again.');
            
            // Reset button
            saveBtn.disabled = false;
            saveBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save
            `;
        }
    });
    
    // Download image
    downloadBtn.addEventListener('click', () => {
        const link = document.createElement('a');
        link.href = capturedImage.src;
        link.download = `capture-${new Date().getTime()}.png`;
        link.click();
    });
    
    // Retake photo
    retakeBtn.addEventListener('click', async () => {
        try {
            // Reopen camera
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'environment' }, 
                audio: false 
            });
            
            video.srcObject = stream;
            
            // Show camera screen
            startScreen.classList.add('hidden');
            cameraScreen.classList.remove('hidden');
            previewScreen.classList.add('hidden');
            
        } catch (err) {
            console.error('Error accessing camera:', err);
            alert('Could not access camera. Please check permissions.');
        }
    });
    
    // Helper function to close camera
    function closeCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }
});