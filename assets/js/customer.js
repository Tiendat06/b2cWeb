window.onload = ()=>{

}
// ======================<<slider>>=======================

let slideIndex = 0

function nextImg(){
    if(slideIndex >= document.getElementsByClassName('slide-show__img').length - 1){
        slideIndex = -1
    }

    let imgItems = document.getElementsByClassName('slide-show__img')[++slideIndex];
    // console.log(imgItems)

    for(let i = 0; i < document.getElementsByClassName('slide-show__img').length; i++){
        let imgD_none = document.getElementsByClassName('slide-show__img')[i];
        if(!imgD_none.classList.contains('d-none')){
            imgD_none.classList.add('d-none');
        }
    }
    
    if(imgItems.classList.contains('d-none')){
        imgItems.classList.remove('d-none');
    }
    
}

function backImg(){
    if(slideIndex <= 0){
        slideIndex = document.getElementsByClassName('slide-show__img').length;
    }

    let backImgItems = document.getElementsByClassName('slide-show__img')[--slideIndex];

    for(let i = 0; i < document.getElementsByClassName('slide-show__img').length; i++){
        let imgD_none = document.getElementsByClassName('slide-show__img')[i];
        if(!imgD_none.classList.contains('d-none')){
            imgD_none.classList.add('d-none');
        }
    }

    if(backImgItems.classList.contains('d-none')){
        backImgItems.classList.remove('d-none');
    }
    
}

function setIntervalSlider(){
    return setInterval(()=>{
        nextImg()
    }, 3000)
}



// ===================<<Product>>==============
function searchItems(){
    let input = document.getElementById('search-input');
    let list = document.getElementById('products__list');

    input.addEventListener('input', function() {
        let query = input.value.toLowerCase();
        let items = list.getElementsByClassName('products__items');

        for (let i = 0; i < items.length; i++) {
            let item = items[i];
            let text = item.textContent.toLowerCase();

            if (text.includes(query)) {
                if(item.classList.contains('d-none')){
                    item.classList.remove('d-none');
                }
            } else {
                if(!item.classList.contains('d-none')){
                    item.classList.add('d-none');
                }
            }
        }
    });
}


// ======================<<Describe>>============


// ==================<<login-signup>>===================
