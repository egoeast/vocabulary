/**
 * Created by User on 21.12.2017.
 */
$('.trans-btn').click(function(){
    //alert("Translate!");
   // alert($( "input[name='_csrf-frontend']" ).attr('value'));
    // alert($("#translation-text").val());
    //startLoadingAnimation();
    $.ajax({

    url: '/simple-translate/translate',
        type: 'post',
        data: {
            _csrf: yii.getCsrfToken(),
            text: $("#translation-text").val(),
        },
        success: function (data) {
           //alert(data.search);
            $( "input[name='Translation[translation]']" ).val(data.search);
        }
    });
    //$("#load-img").delay(1000);
    //stopLoadingAnimation();
});

function startLoadingAnimation() // - функция запуска анимации
{
    // найдем элемент с изображением загрузки и уберем невидимость:
    var imgObj = $("#load-img");
    imgObj.show();

    // вычислим в какие координаты нужно поместить изображение загрузки,
    // чтобы оно оказалось в серидине страницы:
    var centerY = $(window).scrollTop() + ($(window).height() + imgObj.height())/2;
    var centerX = $(window).scrollLeft() + ($(window).width() + imgObj.width())/2;

    // поменяем координаты изображения на нужные:
    imgObj.offset({top: centerY, left: centerX});
}

function stopLoadingAnimation() // - функция останавливающая анимацию
{
    $("#load-img").hide();
}