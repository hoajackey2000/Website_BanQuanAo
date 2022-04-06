// bắt sự kiện cho cái icon
var images = document.querySelectorAll('.image img')
var prev = document.querySelector('.prev')
var next = document.querySelector('.next')
var close = document.querySelector('.close')
var galleryImg = document.querySelector('.gallery__inner img')
var gallery = document.querySelector('.gallery')

var currentIndex = 0; // vị trí click ban đầu = 0

// hiện thị lại images tối ưu code
function showGallery() {

    //điều kiện đến 0 sẽ mất btnprev
    if (currentIndex == 0) {
        prev.classList.add('hide')
    } else {
        prev.classList.remove('hide')
    }

    //điều kiện đến 0 sẽ mất btnnext
    if (currentIndex == images.length - 1) {
        next.classList.add('hide')
    } else {
        next.classList.remove('hide')
    }


    galleryImg.src = images[currentIndex].src
    //////////////// images sẽ lấy ra được tấm ảnh đó 
    /////////////// và nó sẽ đỗ thuộc tính src vào galleryImg
    gallery.classList.add('show')

}


// gán sự kiện icon
images.forEach((item, index) => {
    item.addEventListener('click', function () {
        currentIndex = index
        showGallery()
    })
})

// sự kiện btnclose
close.addEventListener('click', function () {
    gallery.classList.remove('show') // thoát ra khỏi tấm ảnh bằng nút close
})

gallery.addEventListener("click", (e) => {
    if (e.target == e.currentTarget)
        gallery.classList.remove('show');
});

// bắt sự kiện bàn phím
document.addEventListener('keydown', function (e) {
    if (e.keyCode == 27) // keycode là nút Esc bàn phím
    {
        gallery.classList.remove('show')
        // thoát ra khỏi tấm ảnh bằng nút Esc bàn phím
    }
})

// sự kiện btnleft
prev.addEventListener('click', function () {
    if (currentIndex > 0) {
        currentIndex--
        showGallery()
    }
})

next.addEventListener('click', function () {
    if (currentIndex < images.length - 1) {
        currentIndex++
        showGallery()
    }
})








