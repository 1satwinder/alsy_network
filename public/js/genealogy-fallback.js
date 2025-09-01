/**
 * Genealogy Tree Image Fallback Handler
 * Handles failed image loads and replaces them with fallback emoji
 */

document.addEventListener('DOMContentLoaded', function() {
    // Handle failed image loads in genealogy tree
    handleGenealogyImageFallbacks();
});

function handleGenealogyImageFallbacks() {
    // Find all images in genealogy tree
    const genealogyImages = document.querySelectorAll('.genealogy-tree img, .sponsor-genealogy img, .autoPool img');
    
    genealogyImages.forEach(function(img) {
        // Add error handler for failed image loads
        img.addEventListener('error', function() {
            console.log('Image failed to load:', this.src);
            
            // Replace with fallback emoji
            this.src = '/images/blank.svg';
            this.alt = 'Member Avatar';
            
            // Add error class for styling
            this.classList.add('image-fallback');
        });
        
        // Add load handler to remove error class if image loads successfully
        img.addEventListener('load', function() {
            this.classList.remove('image-fallback');
        });
    });
}

// Function to manually trigger fallback for specific images
function setImageFallback(imgElement) {
    if (imgElement) {
        imgElement.src = '/images/blank.svg';
        imgElement.alt = 'Member Avatar';
        imgElement.classList.add('image-fallback');
    }
}

// Export for use in other scripts
window.GenealogyFallback = {
    handleGenealogyImageFallbacks,
    setImageFallback
};
