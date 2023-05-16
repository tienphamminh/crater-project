// JQuery
$(document).ready(function () {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Show Delete modal
    $('.cf-delete').click(function () {
        let id = $(this).val();
        let name = $('#name-delete-' + id).text();
        let email = $('#email-delete-' + id).text();

        $('#id-delete').val(id);
        if (!email.trim()) {
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
        element.innerHTML = `<img src="${imageUrl}" width="200" class="img-thumbnail">`;
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
        slug = '/' + renderSlug.value.trim();
    }
    let url = rootUrl + slug;
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
window.addEventListener("beforeunload", function (e) {
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
    ckfinderGroups.forEach(function (element) {
        let renderImage = element.querySelector('.ckfinder-render-img');
        let showImage = element.querySelector('.ckfinder-show-image');
        let imageUrl = renderImage.value.trim();
        showIconOrImage(showImage, imageUrl);

        renderImage.addEventListener('change', (e) => {
            let imageUrl = e.target.value.trim();
            showIconOrImage(showImage, imageUrl);
        });
    });

}

//======================================================================================================================
// Open CKFinder in a popup window when click the 'Choose Image' button
let chooseImages = document.querySelectorAll('.ckfinder-choose-img');
if (chooseImages !== null) {
    chooseImages.forEach(function (element) {

        element.addEventListener('click', function () {
            // Get the parent of this element that has the class name '.ckfinder-group'
            let parent = this.parentElement;
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
                        parent.querySelector('.ckfinder-show-image').innerHTML = `<img src="${imageUrl}" width="200" class="img-thumbnail">`;
                    });
                    finder.on('file:choose:resizedImage', function (evt) {
                        let fileUrl = evt.data.resizedUrl;
                        // Insert uploaded image filename into input field
                    });
                }
            });
        });
    })
}

// Sizing FontAwesome Icon
let customIcons = document.querySelectorAll('.icon-2x');
if (customIcons !== null) {
    customIcons.forEach(function (element) {
        let iconElement = element.querySelector('i');
        if (iconElement !== null) {
            iconElement.classList.add('fa-2x');
        }
    })
}