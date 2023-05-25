// JQuery
$(document).ready(function () {

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Show Delete modal
    $('.cf-delete').click(function () {
        let id = $(this).val();
        let name = $('#name-delete-' + id).text().trim();
        let email = $('#email-delete-' + id).text().trim();

        $('#id-delete').val(id);
        if (!email) {
            $('#msg-delete').text(name);
        } else {
            $('#msg-delete').text(name + ' - ' + email);
        }
        $('#modal-delete').modal('show');
    });

    // Show Image modal
    $('.image-popup').click(function () {
        let imgTag = $(this).find('img');
        if (imgTag.length) {
            $('.image-preview').attr('src', imgTag.attr('src'));
            $('#modal-image').modal('show');
        }
    });
});
//======================================================================================================================

// Convert a string to a URL-friendly slug
function toSlug(title) {
    // Remove Vietnamese tone marks and diacritical marks
    let slug = title.replace(/[áàảạãăắằẳẵặâấầẩẫậ]+/gi, "a")
        .replace(/[éèẻẽẹêếềểễệ]+/gi, "e")
        .replace(/[iíìỉĩị]+/gi, "i")
        .replace(/[óòỏõọôốồổỗộơớờởỡợ]+/gi, "o")
        .replace(/[úùủũụưứừửữự]+/gi, "u")
        .replace(/[ýỳỷỹỵ]+/gi, "u")
        .replace(/đ+/gi, "d");

    // Normalize the string
    slug = slug.toLowerCase().trim();
    // Remove special characters
    slug = slug.replace(/[^a-z0-9\s_+-]+/g, "");
    // Replace spaces, dashes and underscores with a '-' character
    slug = slug.replace(/[\s_+-]+/g, "-");

    return slug;
}

function updateRenderLink(url) {
    renderLink.querySelector("span a").innerHTML = url;
    renderLink.querySelector("span a").href = url;
}

function showIconOrImage(element, imageUrl) {
    if (imageUrl.startsWith(rootUrl)) {
        element.innerHTML = `<img src="${imageUrl}" class="img-thumbnail img-fluid">`;
    } else if (imageUrl.startsWith('<i class=')) {
        element.innerHTML = `${imageUrl}`;
        element.classList.add('display-4');
    } else {
        element.innerHTML = ``;
    }
}

//======================================================================================================================
// Auto generate slug based on title input field
let sourceTitle = document.querySelector('.source-title');
let renderSlug = document.querySelector('.render-slug');
let renderLink = document.querySelector('.render-link');

if (renderLink !== null) {
    let slug = '';
    if (renderSlug !== null) {
        if (renderSlug.value.trim() !== '') {
            slug = renderSlug.value.trim() + '.html';
        }
    }
    let url = rootUrl + "/" + prefixUrl + '/' + slug;
    renderLink.querySelector('span').innerHTML = `<a href="${url}" target="_blank">${url}</a>`;
}

if (sourceTitle !== null && renderSlug !== null) {
    sourceTitle.addEventListener('keyup', (e) => {
        if (!sessionStorage.getItem('save_slug')) {
            let title = e.target.value;
            if (title !== null) {
                let slug = toSlug(title);
                renderSlug.value = slug;
            }
        }
    });

    sourceTitle.addEventListener('change', () => {
        sessionStorage.setItem('save_slug', '1');

        let url = rootUrl + "/" + prefixUrl + "/" + renderSlug.value.trim() + ".html";
        updateRenderLink(url);
    });

    renderSlug.addEventListener('change', (e) => {
        let slug = e.target.value;
        if (slug.trim() === '') {
            sessionStorage.removeItem('save_slug');
            let newSlug = toSlug(sourceTitle.value);
            e.target.value = newSlug;
        }
        let url = rootUrl + "/" + prefixUrl + "/" + renderSlug.value.trim() + ".html";
        updateRenderLink(url);
    });
}
// Remove session storage when reload page
window.addEventListener("beforeunload", () => {
    sessionStorage.removeItem('save_slug');
});

//======================================================================================================================
// Use CKEditor with class '.editor'
let textAreaElements = document.querySelectorAll('.editor');
if (textAreaElements !== null) {
    textAreaElements.forEach((element, index) => {
        element.id = 'editor-' + (index + 1);
        CKEDITOR.replace(element.id);
    });
}

//======================================================================================================================
// Display FontAwesome Icon or Image when insert icon tag or choose Image
let ckfinderGroups = document.querySelectorAll('.ckfinder-group');
if (ckfinderGroups !== null) {
    ckfinderGroups.forEach((element) => {
        let renderImage = element.querySelector('.ckfinder-render-img');
        let showImage = element.querySelector('.ckfinder-show-img');
        if (showImage !== null) {
            let imageUrl = renderImage.value.trim();
            showIconOrImage(showImage, imageUrl);

            renderImage.addEventListener('change', (e) => {
                let imageUrl = e.target.value.trim();
                showIconOrImage(showImage, imageUrl);
            });
        }
    });
}

//======================================================================================================================
// Open CKFinder in a popup window when click the 'Choose Image' button
function openCKFinder(element) {
    element.addEventListener('click', (e) => {
        // Get the parent of this element that has the class name '.ckfinder-group'
        let parent = e.currentTarget.parentElement;
        while (parent) {
            if (parent.classList.contains('ckfinder-group')) {
                break;
            }
            parent = parent.parentElement;
        }

        CKFinder.popup({
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                finder.on('files:choose', function (evt) {
                    // Insert the uploaded image filename into the input field (.ckfinder-render-img)
                    let imageUrl = evt.data.files.first().getUrl();
                    imageUrl = rootUrl + imageUrl.replace(/\/crater-project/g, "");
                    parent.querySelector('.ckfinder-render-img').value = imageUrl;
                    let showImage = parent.querySelector('.ckfinder-show-img');
                    if (showImage !== null) {
                        showImage.innerHTML = `<img src="${imageUrl}" class="img-thumbnail img-fluid">`;
                    }
                });
                finder.on('file:choose:resizedImage', function (evt) {
                    let fileUrl = evt.data.resizedUrl;
                    // Insert uploaded image filename into input field
                });
            }
        });
    });
}

let chooseImages = document.querySelectorAll('.ckfinder-choose-img');
if (chooseImages !== null) {
    chooseImages.forEach((element) => {
        openCKFinder(element);
    })
}

//======================================================================================================================
// Sizing FontAwesome Icon
let customIcons = document.querySelectorAll('.icon-2x');
if (customIcons !== null) {
    customIcons.forEach((element) => {
        let iconElement = element.querySelector('i');
        if (iconElement !== null) {
            iconElement.classList.add('fa-2x');
        }
    });
}

//======================================================================================================================

function deleteImgItem(removeBtnElement) {
    removeBtnElement.addEventListener('click', (e) => {
        if (confirm('Are you sure want to delete?')) {
            let parent = e.currentTarget.parentElement;
            while (parent) {
                if (parent.classList.contains('img-item')) {
                    break;
                }
                parent = parent.parentElement;
            }
            parent.remove();
        }
    });
}

function showImgItemModal() {
    $('.img-item-popup').click(function () {
        let imgUrl = $(this).val().trim();
        if (imgUrl) {
            $('.image-preview').attr('src', imgUrl);
            $('#modal-image').modal('show');
        }
    });
}

// Image gallery repeater (drag and drop sortable list of img items)
let addImgItem = document.querySelector('.add-img-item');
let imgGallery = document.querySelector('.img-gallery');

if (addImgItem !== null && imgGallery !== null) {
    let imgItems = imgGallery.querySelectorAll('.img-item');
    let imgItemId = 0;

    if (imgItems !== null) {
        imgItemId = imgItems.length;

        imgItems.forEach((element, index) => {
            // Open CKFinder
            let chooseImgItem = element.querySelector(`#choose-img-item-${index}`)
            openCKFinder(chooseImgItem);

            // Delete img-item
            let removeImgItem = element.querySelector(`#remove-img-item-${index}`);
            deleteImgItem(removeImgItem);
        });

        // Show Image modal from input
        showImgItemModal();
    }

    addImgItem.addEventListener('click', (e) => {
        let imgItemHtml = `<!-- Image item -->
                                <div class="img-item ckfinder-group">
                                    <div class="row">
                                        <div class="col-10 col-xl-11">
                                            <div class="input-group mb-3">
                                                <input type="text" name="gallery[]" readonly
                                                       class="form-control ckfinder-render-img img-item-popup"
                                                       placeholder="Choose image..."
                                                       style="cursor: pointer">
                                                <div class="input-group-append">
                                                    <button type="button" id="choose-img-item-${imgItemId}"
                                                            class="btn btn-success">
                                                        <i class="fas fa-upload"></i>
                                                        <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 col-xl-1">
                                            <div class="d-flex">
                                                <div style="width: 65%">
                                                    <button type="button" id="remove-img-item-${imgItemId}"
                                                            class="btn btn-danger btn-block">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="ml-auto d-flex align-items-center drag-handle"
                                                     style="width: 20%; cursor: move;">
                                                    <i class="fas fa-sort fa-lg text-secondary"></i> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /.img-item -->`;

        imgGallery.insertAdjacentHTML('beforeend', imgItemHtml);

        // Open CKFinder
        let chooseImgItem = imgGallery.querySelector(`#choose-img-item-${imgItemId}`);
        openCKFinder(chooseImgItem);

        // Delete img-item
        let removeImgItem = imgGallery.querySelector(`#remove-img-item-${imgItemId}`);
        deleteImgItem(removeImgItem);

        // Show Image modal from input
        showImgItemModal();

        imgItemId++;
    });

    // Sortable jQuery UI
    $("#sortable").sortable({
        opacity: 0.7,
        revert: 200,
        handle: ".drag-handle",
        containment: ".img-gallery-container",
    });
}
