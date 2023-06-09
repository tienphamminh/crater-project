// ================================================= JQuery ============================================================
$(document).ready(function () {

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Show Delete modal
    $('.cf-delete').click(function () {
        let id = $(this).val();
        let msg = $(this).data('msg');

        $('#id-delete').val(id);
        $('#msg-delete').text(msg);

        $('#modal-delete').modal('show');
    });

    // Show Image modal (when click image)
    $('.image-popup').click(function () {
        let imgTag = $(this).find('img');
        if (imgTag.length) {
            $('.image-preview').attr('src', imgTag.attr('src'));
            $('#modal-image').modal('show');
        }
    });

    // Sortable jQuery UI
    $('.sortable').sortable({
        opacity: 0.7,
        revert: 200,
        handle: ".drag-handle",
        containment: ".gallery-container",
    });

    // Toggle-badge when close-open sidebar menu
    $('.toggle-badge').click(function () {
        $(this).find('span.badge').toggle(300);
    });

    $('.opacity-range').ionRangeSlider({
        skin: 'round',
        min: 0,
        max: 1,
        type: 'single',
        step: 0.01,
        postfix: '',
        prettify: false,
        hasGrid: true
    })

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
    } else if (imageUrl.match(/^(<i class="fa)[bdlrs]? fa(-[a-z]+)+("><\/i>)$/)) {
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

let suffixUrl = '.html';
if (renderSlug !== null) {
    if (renderSlug.id === 'category-slug') {
        suffixUrl = '';
    }
}

if (renderLink !== null) {
    let slug = '';
    if (renderSlug !== null) {
        if (renderSlug.value.trim() !== '') {
            slug = renderSlug.value.trim() + suffixUrl;
        }
    }
    let url = rootUrl + '/' + prefixUrl + '/' + slug;
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

        let url = rootUrl + '/' + prefixUrl + '/' + renderSlug.value.trim() + suffixUrl;
        updateRenderLink(url);
    });

    renderSlug.addEventListener('change', (e) => {
        let slug = e.target.value;
        if (slug.trim() === '') {
            sessionStorage.removeItem('save_slug');
            let newSlug = toSlug(sourceTitle.value);
            e.target.value = newSlug;
        }
        let url = rootUrl + '/' + prefixUrl + '/' + renderSlug.value.trim() + suffixUrl;
        updateRenderLink(url);
    });
}
// Remove session storage when reload page
window.addEventListener('beforeunload', () => {
    sessionStorage.removeItem('save_slug');
});

//======================================================================================================================
// Use CKEditor with class '.editor'
let textAreaList = document.querySelectorAll('.editor');
if (textAreaList !== null) {
    textAreaList.forEach((element, index) => {
        element.id = 'editor-' + (index + 1);
        CKEDITOR.replace(element.id);
    });
}

//======================================================================================================================
// Display FontAwesome Icon or Image when insert icon tag or choose Image
let ckfinderGroupList = document.querySelectorAll('.ckfinder-group');
if (ckfinderGroupList !== null) {
    ckfinderGroupList.forEach((element) => {
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

let chooseImageList = document.querySelectorAll('.ckfinder-choose-img');
if (chooseImageList !== null) {
    chooseImageList.forEach((element) => {
        openCKFinder(element);
    })
}

//======================================================================================================================
// Sizing FontAwesome Icon
let customIconList = document.querySelectorAll('.icon-2x');
if (customIconList !== null) {
    customIconList.forEach((element) => {
        let iconElement = element.querySelector('i');
        if (iconElement !== null) {
            iconElement.classList.add('fa-2x');
        }
    });
}

//======================================================================================================================

function deleteItemOfGallery(removeBtnElement, itemClassname) {
    removeBtnElement.addEventListener('click', (e) => {
        if (confirm('Are you sure want to delete?')) {
            let parent = e.currentTarget.parentElement;
            while (parent) {
                if (parent.classList.contains(itemClassname)) {
                    break;
                }
                parent = parent.parentElement;
            }
            parent.remove();
        }
    });
}

// Show Image Modal (when click zoom-in icon)
function viewImg(selector = '.view-img') {
    $(selector).click(function () {
        // console.log($(this).get(0));
        let imgUrl = $(this).parent().siblings('input').val().trim();
        if (imgUrl) {
            $('.image-preview').attr('src', imgUrl);
            $('#modal-image').modal('show');
        }
    });
}

viewImg();

// Show Percent Range Slider
function showPercentRange(selector = '.percent-range') {
    $(selector).ionRangeSlider({
        min: 0,
        max: 100,
        type: 'single',
        step: 1,
        postfix: '%',
        prettify: false,
        hasGrid: true
    });
}

showPercentRange();

function moveItem(upSelector = '.move-up', downSelector = '.move-down') {
    $(upSelector).click(function () {
        let movableItem = $(this).parents('.movable');
        if (movableItem.prev()) {
            movableItem.insertBefore(movableItem.prev());
        }
    });

    $(downSelector).click(function () {
        let movableItem = $(this).parents('.movable');
        if (movableItem.next()) {
            movableItem.insertAfter(movableItem.next());
        }
    });
}

moveItem();

// function moveItem2(element) {
//     element.addEventListener('click', (e) => {
//         console.log(e.target);
//         if (e.target.classList.contains('move-up')) {
//             if (element.previousElementSibling) {
//                 element.parentNode.insertBefore(element, element.previousElementSibling);
//             }
//         } else if (e.target.classList.contains('move-down')) {
//             if (element.nextElementSibling) {
//                 element.parentNode.insertBefore(element.nextElementSibling, element);
//             }
//         }
//     });
// }
//
// let movableItemList = document.querySelectorAll('.movable');
// if (movableItemList !== null) {
//     movableItemList.forEach((element) => {
//         moveItem2(element);
//     });
// }

// ======== Image gallery repeater (drag and drop sortable list of img items) ========
let addImgItem = document.querySelector('.add-img-item');
let imgGallery = document.querySelector('.img-gallery');

if (addImgItem !== null && imgGallery !== null) {
    let imgItemList = imgGallery.querySelectorAll('.img-item');
    if (imgItemList !== null) {
        let removeImgItemList = imgGallery.querySelectorAll('.remove-img-item');
        removeImgItemList.forEach((element) => {
            deleteItemOfGallery(element, 'img-item');
        });
    }

    let imgItemId = 0;
    addImgItem.addEventListener('click', (e) => {
        let imgItemHtml = `<!-- Image item -->
                                <div class="img-item ckfinder-group">
                                    <div class="row">
                                        <div class="col-10 col-xl-11">
                                            <div class="input-group mb-3">
                                                <input type="text" name="gallery[]"
                                                       class="form-control ckfinder-render-img"
                                                       placeholder="Choose image...">
                                                <div class="input-group-append">
                                                    <span class="btn input-group-text" id="view-img-${imgItemId}">
                                                        <i class="fas fa-search-plus"></i>
                                                    </span>
                                                    <button type="button" id="ckfinder-choose-img-${imgItemId}"
                                                            class="btn btn-success">
                                                        <i class="fas fa-upload"></i>
                                                        <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 col-xl-1">
                                            <div class="d-flex">
                                                <!-- Delete Button -->
                                                <div style="width: 65%">
                                                    <button type="button" id="remove-img-item-${imgItemId}"
                                                            class="btn btn-danger btn-block">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <!-- Drag Handle -->
                                                <div class="ml-auto drag-handle"
                                                     style="width: 20%; cursor: move; line-height: 38px;">
                                                    <i class="fas fa-sort fa-lg text-secondary"></i> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- /.img-item -->`;

        imgGallery.insertAdjacentHTML('beforeend', imgItemHtml);

        // Open CKFinder
        let chooseImg = imgGallery.querySelector(`#ckfinder-choose-img-${imgItemId}`);
        openCKFinder(chooseImg);

        // Delete img-item
        let removeImgItem = imgGallery.querySelector(`#remove-img-item-${imgItemId}`);
        deleteItemOfGallery(removeImgItem, 'img-item');

        // Show Image modal from input
        viewImg(`.img-gallery  #view-img-${imgItemId}`);

        imgItemId++;
    });
}

// ======== (Homepage) Slide gallery repeater ========
let addSlideItem = document.querySelector('.add-slide-item');
let slideGallery = document.querySelector('.slide-gallery');

if (addSlideItem !== null && slideGallery !== null) {
    let slideItemList = slideGallery.querySelectorAll('.slide-item');

    if (slideItemList !== null) {
        let removeSlideItemList = slideGallery.querySelectorAll('.remove-slide-item');
        removeSlideItemList.forEach((element) => {
            deleteItemOfGallery(element, 'slide-item');
        });
    }

    let slideItemId = 0;
    addSlideItem.addEventListener('click', (e) => {
        let slideItemHtml = `<div class="slide-item movable">
                                <!-- Child Card -->
                                <div class="card card-primary bg-light mb-4 shadow border">
                                    <div style="position: absolute; top: 0px; right: 0px;">
                                        <div class="btn-group">
                                            <!-- Move UP -->
                                            <span class="btn btn-warning px-2 py-0" id="move-up-${slideItemId}" 
                                                  style="font-size: 25px;">
                                                <i class="fas fa-caret-up"></i>
                                            </span>
                                            <!-- Move DOWN -->
                                            <span class="btn btn-warning px-2 py-0" id="move-down-${slideItemId}"
                                                  style="font-size: 25px;">
                                                <i class="fas fa-caret-down"></i>
                                            </span>
                                        </div>
                                        <!-- Delete Button -->
                                        <button type="button" id="remove-slide-item-${slideItemId}"
                                                class="btn btn-danger px-4">
                                            <span class="d-block d-md-none"><i class="fas fa-times"></i></span>
                                            <span class="d-none d-md-inline">Delete</span>
                                        </button>
                                    </div>
                                    <div class="card-body pt-5">
                                        <div class="row">
                                            <!-- Col Left -->
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Slide Layout</label>
                                                            <select name="home_hero[slider][slide_layout][]" class="form-control">
                                                                <option value="left">Left (Default)</option>
                                                                <option value="right">Right</option>
                                                                <option value="center">Center (No images)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Slide Text Align</label>
                                                            <select name="home_hero[slider][slide_text_align][]" class="form-control">
                                                                <option value="left">Left (Default)</option>
                                                                <option value="right">Right</option>
                                                                <option value="center">Center</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Slide Title</label>
                                                    <input type="text" name="home_hero[slider][slide_title][]" class="form-control"
                                                           placeholder="Slide Title...">
                                                </div>
                                                <div class="form-group">
                                                    <label>Slide Description</label>
                                                    <textarea name="home_hero[slider][slide_desc][]" class="form-control"
                                                              placeholder="Slide Description..."
                                                              style="height: 210px"
                                                    ></textarea>
                                                </div>
                                            </div> <!-- /.col (left) -->
                                            <!-- Col Right -->
                                            <div class="col-md-6">
                                                <!-- View More Button -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>[View More] Button | Text</label>
                                                            <input type="text" name="home_hero[slider][slide_btn_text][]"
                                                                   class="form-control"
                                                                   placeholder="Text of Button...">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>[View More] Button | Link</label>
                                                            <input type="text" name="home_hero[slider][slide_btn_link][]"
                                                                   class="form-control"
                                                                   placeholder="Link of Button...">
                                                        </div>
                                                    </div>
                                                </div> <!-- End View More Button -->
                                                <!-- Play Button -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>[Play] Button | Text</label>
                                                            <input type="text" name="home_hero[slider][slide_play_text][]"
                                                                   class="form-control"
                                                                   placeholder="Text of Button...">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>[Play] Button | Link (YouTube)</label>
                                                            <input type="text" name="home_hero[slider][slide_play_link][]"
                                                                   class="form-control"
                                                                   placeholder="Link of Button...">
                                                        </div>
                                                    </div>
                                                </div> <!-- End Play Button -->
                                                <!-- Slide Background -->
                                                <div class="form-group ckfinder-group">
                                                    <label>Background Image</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="home_hero[slider][slide_background][]"
                                                               class="form-control ckfinder-render-img"
                                                               placeholder="Choose image...">
                                                        <div class="input-group-append">
                                                            <span class="btn input-group-text view-img-${slideItemId}">
                                                                <i class="fas fa-search-plus"></i>
                                                            </span>
                                                            <button type="button"
                                                                    class="btn btn-success ckfinder-choose-img-${slideItemId}">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Slide Image 1 -->
                                                <div class="form-group ckfinder-group">
                                                    <label>Image 1</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="home_hero[slider][slide_image_1][]"
                                                               class="form-control ckfinder-render-img"
                                                               placeholder="Choose image...">
                                                        <div class="input-group-append">
                                                            <span class="btn input-group-text view-img-${slideItemId}">
                                                                <i class="fas fa-search-plus"></i>
                                                            </span>
                                                            <button type="button"
                                                                    class="btn btn-success ckfinder-choose-img-${slideItemId}">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Slide Image 2 -->
                                                <div class="form-group ckfinder-group">
                                                    <label>Image 2</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="home_hero[slider][slide_image_2][]"
                                                               class="form-control ckfinder-render-img"
                                                               placeholder="Choose image...">
                                                        <div class="input-group-append">
                                                            <span class="btn input-group-text view-img-${slideItemId}">
                                                                <i class="fas fa-search-plus"></i>
                                                            </span>
                                                            <button type="button"
                                                                    class="btn btn-success ckfinder-choose-img-${slideItemId}">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- /.col (right) -->
                                        </div> <!-- /.row -->
                                    </div> <!-- /.card-body (child) -->
                                </div> <!-- /.card (child) -->
                            </div> <!-- /.slide-item -->`;

        slideGallery.insertAdjacentHTML('beforeend', slideItemHtml);

        // Open CKFinder
        let chooseImageList = slideGallery.querySelectorAll(`.ckfinder-choose-img-${slideItemId}`);
        chooseImageList.forEach((element) => {
            openCKFinder(element);
        })

        // Show Image modal from input
        viewImg(`.slide-gallery .view-img-${slideItemId}`);

        // Delete slide-item button
        let removeSlideItem = slideGallery.querySelector(`#remove-slide-item-${slideItemId}`);
        deleteItemOfGallery(removeSlideItem, 'slide-item');

        // Move up, down item
        moveItem(`#move-up-${slideItemId}`, `#move-down-${slideItemId}`);

        // let movableItem = slideGallery.querySelector(`#movable-${slideItemId}`);
        // moveItem2(movableItem);

        slideItemId++;
    });
}

// ======== (Homepage-About Company) Skill gallery repeater ========
let addSkillItem = document.querySelector('.add-skill-item');
let skillGallery = document.querySelector('.skill-gallery');

if (addSkillItem !== null && skillGallery !== null) {
    let skillItemList = skillGallery.querySelectorAll('.skill-item');

    if (skillItemList !== null) {
        let removeSkillItemList = skillGallery.querySelectorAll('.remove-skill-item');
        removeSkillItemList.forEach((element) => {
            deleteItemOfGallery(element, 'skill-item');
        });
    }

    let skillItemId = 0;
    addSkillItem.addEventListener('click', (e) => {
        let skillItemHtml = `<!-- Skill Item -->
                                <div class="skill-item movable">
                                    <!-- Child Card -->
                                    <div class="card bg-light mb-4 shadow border">
                                        <div style="position: absolute; top: 0px; right: 0px;">
                                            <div class="btn-group">
                                                <!-- Move UP -->
                                                <span class="btn btn-warning px-2 py-0" id="move-up-${skillItemId}"
                                                      style="font-size: 24px;">
                                                    <i class="fas fa-caret-up"></i>
                                                </span>
                                                <!-- Move DOWN -->
                                                <span class="btn btn-warning px-2 py-0" id="move-down-${skillItemId}"
                                                      style="font-size: 24px;">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                            </div>
                                            <!-- Delete Button -->
                                            <button type="button" id="remove-skill-item-${skillItemId}" 
                                                    class="btn btn-danger px-4">
                                                <span class="d-block d-md-none">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <span class="d-none d-md-inline">Delete</span>
                                            </button>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row">
                                                <!-- Col Left -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Skill Name</label>
                                                        <input type="text" name="home_about[skill][skill_name][]"
                                                               class="form-control"
                                                               placeholder="Skill Name..."
                                                               value="">
                                                    </div>
                                                </div> <!-- /.col (left) -->
                                                <!-- Col Right -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Percentage</label>
                                                        <input type="text" name="home_about[skill][skill_percent][]" 
                                                               id="percent-range-${skillItemId}"
                                                               class="form-control"
                                                               value="">
                                                    </div>
                                                </div> <!-- /.col (right) -->
                                            </div> <!-- /.row -->
                                        </div> <!-- /.card-body (child) -->
                                    </div> <!-- /.card (child) -->
                                </div>
                                <!-- /.skill-item -->`;

        skillGallery.insertAdjacentHTML('beforeend', skillItemHtml);

        // Delete skill-item button
        let removeSkillItem = skillGallery.querySelector(`#remove-skill-item-${skillItemId}`);
        deleteItemOfGallery(removeSkillItem, 'skill-item');

        // Move up, down item
        moveItem(`#move-up-${skillItemId}`, `#move-down-${skillItemId}`);

        // Show percent range
        showPercentRange(`#percent-range-${skillItemId}`);

        skillItemId++;
    });
}

// ======== (Homepage-Fact) Fact gallery repeater ========
let addFactItem = document.querySelector('.add-fact-item');
let factGallery = document.querySelector('.fact-gallery');

if (addFactItem !== null && factGallery !== null) {
    let factItemList = factGallery.querySelectorAll('.fact-item');

    if (factItemList !== null) {
        let removeFactItemList = factGallery.querySelectorAll('.remove-fact-item');
        removeFactItemList.forEach((element) => {
            deleteItemOfGallery(element, 'fact-item');
        });
    }

    let factItemId = 0;
    addFactItem.addEventListener('click', (e) => {
        let factItemHtml = `<!-- Fact Item -->
                                <div class="fact-item movable">
                                    <!-- Child Card -->
                                    <div class="card bg-light mb-4 shadow border">
                                        <div style="position: absolute; top: 0px; right: 0px;">
                                            <div class="btn-group">
                                                <!-- Move UP -->
                                                <span class="btn btn-warning px-2 py-0" id="move-up-${factItemId}"
                                                      style="font-size: 24px;">
                                                    <i class="fas fa-caret-up"></i>
                                                </span>
                                                <!-- Move DOWN -->
                                                <span class="btn btn-warning px-2 py-0" id="move-down-${factItemId}"
                                                      style="font-size: 24px;">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                            </div>
                                            <!-- Delete Button -->
                                            <button type="button" id="remove-fact-item-${factItemId}"
                                                    class="btn btn-danger px-4">
                                                <span class="d-block d-md-none">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <span class="d-none d-md-inline">Delete</span>
                                            </button>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fact Name</label>
                                                        <input type="text" class="form-control"
                                                               name="home_fact[fact][fact_name][]"
                                                               placeholder="Fact Name...">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fact Figure</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   name="home_fact[fact][fact_figure][]"
                                                                   placeholder="Fact Figure...">
                                                            <input type="text" class="form-control"
                                                                   name="home_fact[fact][fact_unit][]"
                                                                   placeholder="Unit...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fact Icon</label>
                                                        <input type="text" class="form-control"
                                                               name="home_fact[fact][fact_icon][]"
                                                               placeholder="Fact Icon...">
                                                    </div>
                                                </div>
                                            </div> <!-- /.row -->
                                        </div> <!-- /.card-body (child) -->
                                    </div> <!-- /.card (child) -->
                                </div>
                                <!-- /.fact-item -->`;

        factGallery.insertAdjacentHTML('beforeend', factItemHtml);

        // Delete fact-item button
        let removeFactItem = factGallery.querySelector(`#remove-fact-item-${factItemId}`);
        deleteItemOfGallery(removeFactItem, 'fact-item');

        // Move up, down item
        moveItem(`#move-up-${factItemId}`, `#move-down-${factItemId}`);

        factItemId++;
    });
}

// ======== (Homepage-Partner) Partner gallery repeater ========
let addPartnerItem = document.querySelector('.add-partner-item');
let partnerGallery = document.querySelector('.partner-gallery');

if (addPartnerItem !== null && partnerGallery !== null) {
    let partnerItemList = partnerGallery.querySelectorAll('.partner-item');

    if (partnerItemList !== null) {
        let removePartnerItemList = partnerGallery.querySelectorAll('.remove-partner-item');
        removePartnerItemList.forEach((element) => {
            deleteItemOfGallery(element, 'partner-item');
        });
    }

    let partnerItemId = 0;
    addPartnerItem.addEventListener('click', (e) => {
        let partnerItemHtml = `<!-- Partner Item -->
                                    <div class="partner-item movable">
                                        <!-- Child Card -->
                                        <div class="card bg-light mb-4 shadow border">
                                            <div style="position: absolute; top: 0px; right: 0px;">
                                                <div class="btn-group">
                                                    <!-- Move UP -->
                                                    <span class="btn btn-warning px-2 py-0" id="move-up-${partnerItemId}"
                                                          style="font-size: 24px;">
                                                        <i class="fas fa-caret-up"></i>
                                                    </span>
                                                    <!-- Move DOWN -->
                                                    <span class="btn btn-warning px-2 py-0" id="move-down-${partnerItemId}"
                                                          style="font-size: 24px;">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                                <!-- Delete Button -->
                                                <button type="button" id="remove-partner-item-${partnerItemId}"
                                                        class="btn btn-danger px-4">
                                                    <span class="d-block d-md-none">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="d-none d-md-inline">Delete</span>
                                                </button>
                                            </div>
                                            <div class="card-body pt-5">
                                                <div class="row">
                                                    <!-- Logo -->
                                                    <div class="col-md-6">
                                                        <div class="form-group ckfinder-group">
                                                            <label>Partner Logo</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text"
                                                                       name="home_partner[partner][partner_logo][]"
                                                                       class="form-control ckfinder-render-img"
                                                                       placeholder="Choose image...">
                                                                <div class="input-group-append">
                                                                <span class="btn input-group-text" id="view-img-${partnerItemId}">
                                                                    <i class="fas fa-search-plus"></i>
                                                                </span>
                                                                    <button type="button" id="ckfinder-choose-img-${partnerItemId}"
                                                                            class="btn btn-success">
                                                                        <i class="fas fa-upload"></i>
                                                                        <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Link -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Partner Link</label>
                                                            <input type="text" class="form-control"
                                                                   name="home_partner[partner][partner_link][]"
                                                                   placeholder="Link of Logo...">
                                                        </div>
                                                    </div>
                                                </div> <!-- /.row -->
                                            </div> <!-- /.card-body (child) -->
                                        </div> <!-- /.card (child) -->
                                    </div>
                                    <!-- /.partner-item -->`;

        partnerGallery.insertAdjacentHTML('beforeend', partnerItemHtml);

        // Open CKFinder
        let chooseImage = partnerGallery.querySelector(`#ckfinder-choose-img-${partnerItemId}`);
        openCKFinder(chooseImage);

        // Show Image modal from input
        viewImg(`.partner-gallery #view-img-${partnerItemId}`);

        // Delete partner-item button
        let removePartnerItem = partnerGallery.querySelector(`#remove-partner-item-${partnerItemId}`);
        deleteItemOfGallery(removePartnerItem, 'partner-item');

        // Move up, down item
        moveItem(`#move-up-${partnerItemId}`, `#move-down-${partnerItemId}`);

        partnerItemId++;
    });
}

// ======== (About-Leader) Leader gallery repeater ========
let addLeaderItem = document.querySelector('.add-leader-item');
let leaderGallery = document.querySelector('.leader-gallery');

if (addLeaderItem !== null && leaderGallery !== null) {
    let leaderItemList = leaderGallery.querySelectorAll('.leader-item');

    if (leaderItemList !== null) {
        let removeLeaderItemList = leaderGallery.querySelectorAll('.remove-leader-item');
        removeLeaderItemList.forEach((element) => {
            deleteItemOfGallery(element, 'leader-item');
        });
    }

    let leaderItemId = 0;
    addLeaderItem.addEventListener('click', (e) => {
        let leaderItemHtml = `<!-- Leader Item -->
                                    <div class="leader-item movable">
                                        <!-- Child Card -->
                                        <div class="card bg-light mb-4 shadow border">
                                            <div style="position: absolute; top: 0px; right: 0px;">
                                                <div class="btn-group">
                                                    <!-- Move UP -->
                                                    <span class="btn btn-warning px-2 py-0" id="move-up-${leaderItemId}"
                                                          style="font-size: 24px;">
                                                        <i class="fas fa-caret-up"></i>
                                                    </span>
                                                    <!-- Move DOWN -->
                                                    <span class="btn btn-warning px-2 py-0" id="move-up-${leaderItemId}"
                                                          style="font-size: 24px;">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                                <!-- Delete Button -->
                                                <button type="button" id="remove-leader-item-${leaderItemId}"
                                                        class="btn btn-danger px-4">
                                                    <span class="d-block d-md-none">
                                                        <i class="fas fa-times"></i>
                                                    </span>
                                                    <span class="d-none d-md-inline">Delete</span>
                                                </button>
                                            </div>
                                            <div class="card-body pt-5">
                                                <!-- Avatar -->
                                                <div class="form-group ckfinder-group">
                                                    <label>Leader Avatar</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text"
                                                               name="about_leader[leader][leader_avt][]"
                                                               class="form-control ckfinder-render-img"
                                                               placeholder="Choose image...">
                                                        <div class="input-group-append">
                                                                <span class="btn input-group-text" id="view-img-${leaderItemId}">
                                                                    <i class="fas fa-search-plus"></i>
                                                                </span>
                                                            <button type="button" id="ckfinder-choose-img-${leaderItemId}"
                                                                    class="btn btn-success">
                                                                <i class="fas fa-upload"></i>
                                                                <span class="d-none d-xl-inline ml-1">Choose Image</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Leader Name</label>
                                                            <input type="text" class="form-control"
                                                                   name="about_leader[leader][leader_name][]"
                                                                   placeholder="Leader Name...">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Leader Role</label>
                                                            <input type="text" class="form-control"
                                                                   name="about_leader[leader][leader_role][]"
                                                                   placeholder="Leader Role...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Facebook</label>
                                                            <input type="text" class="form-control"
                                                                   name="about_leader[leader][leader_fb][]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Twitter</label>
                                                            <input type="text" class="form-control"
                                                                   name="about_leader[leader][leader_twitter][]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>LinkedIn</label>
                                                            <input type="text" class="form-control"
                                                                   name="about_leader[leader][leader_linked][]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Behance</label>
                                                            <input type="text" class="form-control"
                                                                   name="about_leader[leader][leader_behance][]">
                                                        </div>
                                                    </div>
                                                </div> <!-- /.row -->
                                            </div> <!-- /.card-body (child) -->
                                        </div> <!-- /.card (child) -->
                                    </div>
                                    <!-- /.leader-item -->`;

        leaderGallery.insertAdjacentHTML('beforeend', leaderItemHtml);

        // Open CKFinder
        let chooseImage = leaderGallery.querySelector(`#ckfinder-choose-img-${leaderItemId}`);
        openCKFinder(chooseImage);

        // Show Image modal from input
        viewImg(`.leader-gallery #view-img-${leaderItemId}`);

        // Delete leader-item button
        let removeLeaderItem = leaderGallery.querySelector(`#remove-leader-item-${leaderItemId}`);
        deleteItemOfGallery(removeLeaderItem, 'leader-item');

        // Move up, down item
        moveItem(`#move-up-${leaderItemId}`, `#move-down-${leaderItemId}`);

        leaderItemId++;
    });
}
