
document.addEventListener('DOMContentLoaded', function () {
    const sectionTwo = document.getElementById('two');
    const sectionThree = document.querySelector('.three');
    const lightbox = document.getElementById('product-lightbox');
    const backButton = lightbox.querySelector('.back');
    const filtersSection = document.getElementById('filters');
    const fix = document.getElementById('.fix');

    function openProductDetails(productId) {
        // Redirect to the product details page with the product_id
        window.location.href = `./shop_user.php?product_id=${productId}`;
    }

    function openLightbox() {
        lightbox.style.display = 'flex';
        sectionTwo.style.display = 'none';
        sectionThree.style.display = 'none';
        filtersSection.style.display = 'none';
    }

    function closeLightbox() {
        lightbox.style.display = 'none';
        sectionTwo.style.display = 'block';
        sectionThree.style.display = 'block';
        filtersSection.style.display = 'block';
    
        window.location.href = "home_user.php?shop_user=true";
    }
    
    
    

    // Check if the product_id is present in the URL and open the lightbox accordingly
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const productId = urlParams.get('product_id');

    if (productId) {
        openLightbox();
    }

    // Attach event listeners
    backButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        closeLightbox();
    });

    sectionThree.addEventListener('click', function () {
        // Do something when sectionThree is clicked
        // You can customize this behavior as needed
        console.log('Section Three Clicked');
    });
});
