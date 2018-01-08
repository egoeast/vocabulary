/**
 * Created by User on 21.12.2017.
 */
$(document).ready(function(){

      $("#vocabulary-lang_pair").val("ru-en");
      $(".lang-pair").change(function(){
          $("#vocabulary-lang_pair").val($("#left").val()+"-"+$("#right").val());
      })
});

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
            pair: $("#lang-pair").val(),
        },
        success: function (data) {
            $("#translation-translation" ).val(data.result);
        }
    });
    //$("#load-img").delay(1000);
    //stopLoadingAnimation();
});

$('.dic-trans-btn').click(function(){
    //alert("Translate!");
    // alert($( "input[name='_csrf-frontend']" ).attr('value'));
    // alert($("#translation-text").val());
    //startLoadingAnimation();

    $.ajax({

        url: '/vocabulary/translate',
        type: 'post',
        data: {
            _csrf: yii.getCsrfToken(),
            text: $("#translation-text").val(),
            //pair: $("#lang-pair").val(),
        },
        success: function (data) {
            console.log(data.result);
            var arr = data.result.def;
           arr.forEach(function(item, i, arr) {
                console.log(arr[i].pos);
                $("#trans-cont" ).html(arr[i].pos);
            });

            $("#translation-translation" ).val(data.result);
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