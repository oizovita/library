
function incrementLikeCount(id) {
    $.post('/books/' + id, { like_count: true });
    alert(
        "Книга свободна и ты можешь прийти за ней." +
        " Наш адрес: г. Кропивницкий, переулок Васильевский 10, 5 этаж." +
        " Лучше предварительно прозвонить и предупредить нас, чтоб " +
        " не попасть в неловкую ситуацию. Тел. 099 196 24 69" +
        " \n\n" +
        "******************\n" +
        "Кстати, если вы читаете этот текст, то автор сайта еще не отсылает ajax запрос на увеличение количества кликов на кнопку по этой книге"
    );
}

function incrementViewCount(id) {
    $.post('/books/' + id, { view_count: true });
}