/**
 * Created by User on 21.12.2017.
 */
$('.trans-btn').click(function(){
    //alert("Translate!");
   // alert($( "input[name='_csrf-frontend']" ).attr('value'));
     alert($("#translation-text").val());

    $.ajax({
        url: '/yii-voc/frontend/web/simple-translate/translate',
        type: 'post',
        data: {
            _csrf: yii.getCsrfToken(),
            text: $("#translation-text").val(),
        },
        success: function (data) {
            console.log(data);
        }
    });
});