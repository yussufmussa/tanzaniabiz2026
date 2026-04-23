
document.querySelectorAll('.day-closed-check').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const row = this.closest('.working-hour-row');
        const openTime = row.querySelector('.open-time');
        const closeTime = row.querySelector('.close-time');
        const is247Check = row.querySelector('.day-24-7-check');

        if (this.checked) {
            openTime.disabled = true;
            closeTime.disabled = true;
            openTime.value = '';
            closeTime.value = '';
            is247Check.checked = false;
            is247Check.disabled = true;
        } else {
            openTime.disabled = false;
            closeTime.disabled = false;
            is247Check.disabled = false;
        }
    });
});

document.querySelectorAll('.day-24-7-check').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const row = this.closest('.working-hour-row');
        const openTime = row.querySelector('.open-time');
        const closeTime = row.querySelector('.close-time');
        const closedCheck = row.querySelector('.day-closed-check');

        if (this.checked) {
            openTime.disabled = true;
            closeTime.disabled = true;
            openTime.value = '';
            closeTime.value = '';
            closedCheck.checked = false;
            closedCheck.disabled = true;
        } else {
            openTime.disabled = false;
            closeTime.disabled = false;
            closedCheck.disabled = false;
        }
    });
});

// Photo upload limit
document.getElementById('photos').addEventListener('change', function (e) {
    const files = e.target.files;
    const currentCount = parseInt(document.getElementById('currentPhotoCount').textContent);

    if (files.length + currentCount > 6) {
        alert('You can only upload a maximum of 6 photos. You currently have ' + currentCount + ' photos.');
        this.value = '';
        return;
    }

    // Preview logic here (same as before)
});

// Product limit
document.getElementById('addProduct').addEventListener('click', function () {
    const productCount = document.querySelectorAll('.product-item').length;

    if (productCount >= 3) {
        alert('You can only add a maximum of 3 products.');
        return;
    }

    const container = document.getElementById('productsContainer');
    const newProduct = `
<div class="product-item card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Product Name *</label>
                <input type="text" class="form-control" name="products[${productCount}][name]" >
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="products[${productCount}][price]">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="2" name="products[${productCount}][description]"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Product Photo</label>
            <input type="file" class="form-control" name="products[${productCount}][photo]" accept="image/*">
        </div>
        <button type="button" class="btn btn-danger btn-sm remove-product">
            <i class="bi bi-trash"></i> Remove Product
        </button>
    </div>
</div>
`;
    container.insertAdjacentHTML('beforeend', newProduct);
    updateProductCount();
});

// Remove product
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-product') || e.target.closest('.remove-product')) {
        const button = e.target.classList.contains('remove-product') ? e.target : e.target.closest(
            '.remove-product');
        if (document.querySelectorAll('.product-item').length > 1) {
            button.closest('.product-item').remove();
            updateProductCount();
        } else {
            alert('At least one product is .');
        }
    }
});

function updateProductCount() {
    document.getElementById('productCount').textContent = document.querySelectorAll('.product-item').length;
}

$(document).ready(function () {
    $('#subcategory_id').select2();
    $('#category_id').select2();
    $('#city_id').select2();
    $('#subcategory_div').hide();

    $('#category_id').on('change', function () {
        let category_id = $(this).val();
        $('#loader').show();

        setTimeout(function () {
            $('#subcategory_div').show();
        }, 1000);

        $.ajax({
            type: "GET",
            url: '/getSubCategories',
            data: {
                'id': category_id
            },
            success: function (data) {
                $('#subcategory_id').empty();

                if (data.length > 0) {
                    $.each(data, function (index, subcategory) {
                        $('#subcategory_id').append('<option value="' +
                            subcategory.id + '">' + subcategory.name +
                            '</option>');
                    });
                } else {
                    $('#subcategories').append(
                        '<option value="">No Subcategories</option>');
                }

                setTimeout(function () {
                    $('#loader').hide();
                }, 1000);
            },
            error: function () {
                $('#loader').hide();
            }
        });
    });

    $(document).on('click', '.btn_addProduct', function () {
        let html =
            '<div class="input-group control-group mt-2"><input type="text" name="products[]" placeholder="Eg. Holiday Package" class="form-control"><div class="input-group-btn"><button class="btn btn-danger btn-remove" type="button"><i class="fa fa-trash-alt"></i></button></div></div>';
        $('#tableProduct').append(html);
    });

    $('.gallery').change(function () {
        let id = this.id.split('_')[1];
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#galleryPreview_' + id).attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $(document).on('click', '.btn_addSocialMediaUsername', function () {
        let html = '<tr>';
        html +=
            '<td class="form-group"><select name="social_media_id[]" class="form-control"><option value="">--Select--</option>@foreach ($socialmedias as $media)<option value="{{ $media->id }}">{{ $media->name }}</option>@endforeach</select></td>';
        html +=
            '<td><input type="text" name="username[]" placeholder="Eg. username" class="form-control"></td>';
        html +=
            '<td style="width:10px !important;"><button type="button" name="remove" class="btn btn-sm btn-danger btn-remove"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></td>';
        html += '</tr>';
        $('#tableSocialMedia').append(html);
    });

    $(document).on('click', '.btn-remove', function () {
        $(this).parents(".control-group").remove();
    });

    $(document).on('click', '.btn-remove', function () {
        $(this).closest("tr").remove();
    });

    $('#logo').change(function () {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#businessLogo').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
});

let listingId = document.getElementById('business_listing_id').value;
let productCount = document.querySelectorAll('.product-item').length || 1;

// General Form Submission
document.getElementById('generalTabForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const url = listingId ? `/business-listings/${listingId}` : '/business-listings';
    const method = listingId ? 'PUT' : 'POST';

    if (listingId) {
        formData.append('_method', 'PUT');
    }

    showLoader('Saving general information...');

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            hideLoader();
            if (data.success) {
                clearValidationErrors();
                listingId = data.business_listing_id;
                document.getElementById('business_listing_id').value = listingId;
                showSuccessMessage(data.message);
                nextTab('photos-tab');
            }
        })
        .catch(error => {
            hideLoader();
            if (error.errors) {
                showValidationErrors(error.errors);
            }
            handleAjaxError(error);
        });
});

// Photo upload with preview
document.getElementById('photos').addEventListener('change', function (e) {
    const files = e.target.files;
    const currentCount = parseInt(document.getElementById('currentPhotoCount').textContent);
    const previewContainer = document.getElementById('photoPreview');

    // Check total limit
    if (files.length + currentCount > 6) {
        alert('You can only upload a maximum of 6 photos. You currently have ' + currentCount + ' photos.');
        this.value = '';
        return;
    }

    // Create previews for newly selected files
    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-md-4 col-lg-2 mb-3 new-photo';
            
            col.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-thumbnail" alt="Photo Preview">
                    <button type="button" 
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-preview"
                        data-file-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            
            previewContainer.appendChild(col);
        };
        
        reader.readAsDataURL(file);
    });

    // Update count
    updatePhotoCount();
});

// Handle deletion of existing photos (from database)
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-photo')) {
        const button = e.target.closest('.delete-photo');
        const photoId = button.dataset.photoId;
        
        if (confirm('Are you sure you want to delete this photo?')) {
            deleteExistingPhoto(photoId, button);
        }
    }
});

// Handle deletion of preview photos (not yet uploaded)
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-preview')) {
        const button = e.target.closest('.delete-preview');
        const photoElement = button.closest('.col-md-4');
        
        // Remove the preview
        photoElement.remove();
        
        // Reset the file input to remove the deleted file
        // Note: We can't selectively remove files from input, so we clear it
        // Users will need to reselect if they want to change selection
        document.getElementById('photos').value = '';
        
        // Update count
        updatePhotoCount();
    }
});

// Delete existing photo from database
function deleteExistingPhoto(photoId, button) {
    showLoader('Deleting photo...');
    
    fetch(`/business-listings/photos/${photoId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoader();
        
        if (data.success) {
            // Remove the photo element
            button.closest('.col-md-4').remove();
            
            // Update the current photo count
            const currentCount = parseInt(document.getElementById('currentPhotoCount').textContent);
            document.getElementById('currentPhotoCount').textContent = currentCount - 1;
            
            showSuccessMessage(data.message || 'Photo deleted successfully');
        } else {
            alert(data.message || 'Failed to delete photo');
        }
    })
    .catch(error => {
        hideLoader();
        handleAjaxError(error);
    });
}

// Update photo count based on existing + new previews
function updatePhotoCount() {
    const existingPhotos = document.querySelectorAll('.delete-photo').length;
    const newPreviews = document.querySelectorAll('.delete-preview').length;
    const totalCount = existingPhotos + newPreviews;
    
    document.getElementById('currentPhotoCount').textContent = totalCount;
}

// Photos Form Submission
document.getElementById('photosForm').addEventListener('submit', function (e) {
    e.preventDefault();

    if (!listingId) {
        alert('Please save basic information first');
        return;
    }

    const formData = new FormData(this);
    const fileInput = document.getElementById('photos');
    
    // Check if there are files to upload
    if (fileInput.files.length === 0) {
        alert('Please select at least one photo to upload');
        return;
    }

    showLoader('Saving photos...');

    fetch(`/business-listings/${listingId}/photos`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            hideLoader();

            if (data.success) {
                showSuccessMessage(data.message);
                
                // Clear the file input
                fileInput.value = '';
                
                // Remove preview elements (they're now saved)
                document.querySelectorAll('.new-photo').forEach(el => el.remove());
                
                // Update with actual saved photos if returned
                if (data.photos) {
                    updateSavedPhotos(data.photos);
                }
                
                // Update count
                updatePhotoCount();
                
                // Move to next tab
                nextTab('products-tab');
            }
        })
        .catch(error => {
            hideLoader();
            handleAjaxError(error);
        });
});

// Optional: Update UI with saved photos after upload
function updateSavedPhotos(photos) {
    const previewContainer = document.getElementById('photoPreview');
    
    photos.forEach(photo => {
        const col = document.createElement('div');
        col.className = 'col-md-4 col-lg-2 mb-3';
        
        col.innerHTML = `
            <div class="position-relative">
                <img src="${photo.url}" class="img-thumbnail" alt="Photo">
                <button type="button"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 delete-photo"
                    data-photo-id="${photo.id}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        
        previewContainer.appendChild(col);
    });
}


// Products Form Submission
document.getElementById('productsForm').addEventListener('submit', function (e) {
    e.preventDefault();

    if (!listingId) {
        alert('Please save basic information first');
        return;
    }

    const formData = new FormData();

    document.querySelectorAll('.product-item').forEach((item, index) => {
        formData.append(`products[${index}][product_name]`,
            item.querySelector('[name*="[product_name]"]').value);

        formData.append(`products[${index}][price]`,
            item.querySelector('[name*="[price]"]').value);

        formData.append(`products[${index}][description]`,
            item.querySelector('[name*="[description]"]').value);

        const fileInput = item.querySelector('[name*="[photo]"]');
        if (fileInput.files.length > 0) {
            formData.append(`products[${index}][photo]`, fileInput.files[0]);
        }
    });

    showLoader('Saving products...');

    fetch(`/business-listings/${listingId}/products`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            hideLoader();

            if (data.success) {
                showSuccessMessage(data.message);
                nextTab('extra-tab');
            }
        })
        .catch(error => {
            hideLoader();
            handleAjaxError(error);
        });
});

// Extra Form Submission
document.getElementById('extraForm').addEventListener('submit', function (e) {
    e.preventDefault();

    if (!listingId) {
        alert('Please save basic information first');
        return;
    }

   const formData = new FormData(this);
   document.querySelectorAll('select:disabled')
    .forEach(el => el.disabled = false);

    showLoader('Finalizing listing...');

    fetch(`/business-listings/${listingId}/extra-info`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',

        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            hideLoader();

            if (data.success) {
                showSuccessMessage(data.message);

                if (data.redirect) {
                    setTimeout(() => window.location.href = data.redirect, 1500);
                }
            }
        })
        .catch(error => {
            hideLoader();
            handleAjaxError(error);
        });
});

// Add Product functionality
document.getElementById('addProduct').addEventListener('click', function () {
    const container = document.getElementById('productsContainer');
    const newProduct = `
<div class="product-item border p-3 mb-3">
    <div class="mb-3">
        <label class="form-label">Product Name *</label>
        <input type="text" class="form-control" name="products[${productCount}][product_name]" >
    </div>
    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" name="products[${productCount}][price]">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="products[${productCount}][description]"></textarea>
    </div>
    <button type="button" class="btn btn-danger btn-sm remove-product">Remove</button>
</div>
`;
    container.insertAdjacentHTML('beforeend', newProduct);
    productCount++;
});

// Remove product functionality
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-product')) {
        if (document.querySelectorAll('.product-item').length > 1) {
            e.target.closest('.product-item').remove();
        } else {
            alert('At least one product is ');
        }
    }
});

// Photo preview
document.getElementById('photos').addEventListener('change', function (e) {
    const preview = document.getElementById('photoPreview');
    preview.innerHTML = '';

    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const col = document.createElement('div');
            col.className = 'col-md-3 mb-3';
            col.innerHTML =
                `<img src="${e.target.result}" class="img-thumbnail" alt="Preview">`;
            preview.appendChild(col);
        }
        reader.readAsDataURL(file);
    });
});

// Skip tab functionality
document.querySelectorAll('.skip-tab-btn').forEach(button => {
    button.addEventListener('click', function () {
        const nextTabId = this.getAttribute('data-next-tab');
        nextTab(nextTabId);
    });
});

// Helper Functions
function showLoader(message = 'Processing...') {
    if (!document.getElementById('ajaxLoader')) {
        const loader = document.createElement('div');
        loader.id = 'ajaxLoader';
        loader.style.cssText = `
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background: rgba(0,0,0,0.7); 
    z-index: 9999; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    flex-direction: column;
`;
        loader.innerHTML = `
    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p class="text-light mt-3" id="loaderMessage">${message}</p>
`;
        document.body.appendChild(loader);
    } else {
        document.getElementById('loaderMessage').textContent = message;
        document.getElementById('ajaxLoader').style.display = 'flex';
    }
}

function hideLoader() {
    const loader = document.getElementById('ajaxLoader');
    if (loader) {
        loader.style.display = 'none';
    }
}

function showSuccessMessage(message) {
    toastr.success(message, 'Success', {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 3000,
        escapeHtml: false
    });
}


// Error Handling Message
function handleAjaxError(error) {
    let errorMessage = 'An error occurred. Please try again.';

    if (error.errors && error.message) {
        errorMessage = error.message;
    } else if (error.message) {
        errorMessage = error.message;
    }

    if (error.responseJSON && error.responseJSON.errors) {
        const errors = error.responseJSON.errors;
        errorMessage = '<ul class="mb-0">';
        Object.values(errors).forEach(value => {
            errorMessage += `<li>${value[0]}</li>`;
        });
        errorMessage += '</ul>';
    } else if (error.responseJSON && error.responseJSON.message) {
        errorMessage = error.responseJSON.message;
    }

    toastr.error(errorMessage, 'Error', {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 5000,
        escapeHtml: false
    });
}

function nextTab(tabId) {
    const tabElement = document.getElementById(tabId);
    tabElement.classList.remove('disabled');
    tabElement.removeAttribute('disabled');

    const tab = new bootstrap.Tab(tabElement);
    tab.show();

    const currentTab = document.querySelector('.nav-link.active');
    if (currentTab && currentTab.id !== tabId) {
        currentTab.classList.add('completed');
    }
}

function prevTab(tabId) {
    const tab = new bootstrap.Tab(document.getElementById(tabId));
    tab.show();
}

function showValidationErrors(errors) {
    clearValidationErrors();

    Object.keys(errors).forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = errors[field][0];
            input.parentNode.appendChild(errorDiv);
        }
    });
}

function clearValidationErrors() {
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
}
