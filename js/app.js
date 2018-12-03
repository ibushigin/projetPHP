/*Changement Background*/
$(function () {
    var carousel = $('.carousel');
    var backgrounds = [
      'url(http://placekitten.com/2000/886)',
      'url(https://placebear.com/g/2000/886)'];
    var current = 0;

    function nextBackground() {
        carousel.css(
            'background',
        backgrounds[current = ++current % backgrounds.length]);

        setTimeout(nextBackground, 5000);
    }
    setTimeout(nextBackground, 5000);
    carousel.css('background', backgrounds[0]);
});
