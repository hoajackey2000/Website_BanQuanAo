// bắt sự kiện cho cái icon
var images__deatail = document.querySelectorAll('.image__detail img')
var prev__detail = document.querySelector('.prev__detail')
var next__detail = document.querySelector('.next__detail')
var close__detail = document.querySelector('.close__detail')
var galleryImg__detail = document.querySelector('.gallery__inner__detail img')
var gallery__detail = document.querySelector('.gallery__detail')

var currentIndex__detail = 0; // vị trí click ban đầu = 0

// hiện thị lại images__deatail tối ưu code
function showGallery__detail() {

    //điều kiện đến 0 sẽ mất btnprev
    if (currentIndex__detail == 0) {
        prev__detail.classList.add('hide')
    } else {
        prev__detail.classList.remove('hide')
    }

    //điều kiện đến 0 sẽ mất btnnext
    if (currentIndex__detail == images__deatail.length - 1) {
        next__detail.classList.add('hide')
    } else {
        next__detail.classList.remove('hide')
    }


    galleryImg__detail.src = images__deatail[currentIndex__detail].src
    //////////////// images__deatail sẽ lấy ra được tấm ảnh đó 
    /////////////// và nó sẽ đỗ thuộc tính src vào galleryImg__detail
    gallery__detail.classList.add('show')

}


// gán sự kiện icon
images__deatail.forEach((item, index) => {
    item.addEventListener('click', function () {
        currentIndex__detail = index
        showGallery__detail()
    })
})

// sự kiện btnclose
close__detail.addEventListener('click', function () {
    gallery__detail.classList.remove('show') // thoát ra khỏi tấm ảnh bằng nút close
})

gallery__detail.addEventListener("click", (e) => {
    if (e.target == e.currentTarget)
        gallery__detail.classList.remove('show');
});

// bắt sự kiện bàn phím
document.addEventListener('keydown', function (e) {
    if (e.keyCode == 27) // keycode là nút Esc bàn phím
    {
        gallery__detail.classList.remove('show')
        // thoát ra khỏi tấm ảnh bằng nút Esc bàn phím
    }
})

// sự kiện btnleft
prev__detail.addEventListener('click', function () {
    if (currentIndex__detail > 0) {
        currentIndex__detail--
        showGallery__detail()
    }
})

next__detail.addEventListener('click', function () {
    if (currentIndex__detail < images__deatail.length - 1) {
        currentIndex__detail++
        showGallery__detail()
    }
})