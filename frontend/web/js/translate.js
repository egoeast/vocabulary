/**
 * Created by User on 21.12.2017.
 */
$(document).ready(function(){

      $("#vocabulary-lang_pair").val("ru-en");
      $(".lang-pair").change(function(){
          $("#vocabulary-lang_pair").val($("#left").val()+"-"+$("#right").val());
      })
    $("#trans-variants a").on( "click", function(){
        alert("sfsdf");
        //$("#translation-translation").val(this.text);
    });
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
            console.log(data);
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
    var variantCont = $("#trans-variants");
    var exampleCont = $("#trans-example" );
    variantCont.empty();
    exampleCont.empty();
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

            var partOfSpeech = data.result.def;
            //Перебираем массив с частями речи(сущ, прилаг и т.д.)
            partOfSpeech.forEach(function(part, partOfSpeech) {
               // console.log(arr[i].pos);
                variantCont.append('<h3>'+part.pos+'</h3>');
                var variantOfTrans = part.tr;
                //Перебираем варианты перевода для каждой части речи
                variantOfTrans.forEach(function(variant, variantOfTrans) {
                   variantCont.append('<a class="add-var">'+variant.text+'</a>'+', ');
                    var examples = variant.ex;
                    if (examples!=null){
                    examples.forEach(function(examp, examples) {
                        var exampleText = '<p>' + examp.text;
                        if (examp.tr != null) {
                            exampleText += ' - ' + examp.tr[0].text + '</p>';
                        } else {
                            exampleText += '</p>';
                        }
                        exampleCont.append(exampleText);
                    });}
               });

            });

            //$("#translation-translation" ).val(data.result);
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