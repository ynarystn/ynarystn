let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

subImages = document.querySelectorAll('.update-product .image-container .sub-images img');
mainImage = document.querySelector('.update-product .image-container .main-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      let src = images.getAttribute('src');
      mainImage.src = src;
   }
});

// Update Product
document.addEventListener('DOMContentLoaded', function () {
   // Listen for the modal to be shown
   $('#updateProductModal').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget);
     var productId = button.data('productid');
 
     // Load the update form using AJAX
     $.ajax({
       url: 'admin_update_product.php?update=' + productId,
       type: 'GET',
       success: function (data) {
         $('#updateProductModalBody').html(data);
       },
     });
   });
 });
 