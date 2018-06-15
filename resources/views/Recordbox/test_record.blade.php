<script>
    //오답리스트 로드할 위치(id값)를 변수에 담기
    var WrongList = "modal_allWrongAnswerList";
    var wrongsData = data['wrongs'];
    var leftOrRight = "";

    $('.wrong_left').empty();
    $('.wrong_right').empty();

    if(wrongsData.length == 0){
        $('.wrong_left').text("오답 내용이 없습니다.");
        $('.wrong_left').addClass("noBoardLine");
        $('.wrong_right').addClass("noBoardLine");

    }else{

        for(var i = 0 ; i < wrongsData.length ; i++ ){

            if(i < 5){
                leftOrRight = "wrong_left";
                $('.wrong_left').removeClass("noBoardLine");
                $('.wrong_right').addClass("noBoardLine");
            }else{
                leftOrRight = "wrong_right";
                $('.wrong_right').removeClass("noBoardLine");
            }

            $('.' + leftOrRight).append($('<table>').attr('class', 'table_wrongList')
                .append($('<thead>')
                    .append($('<tr>')
                        .append($('<th>')
                            .append($('<div>').text(wrongsData[i]['number'])))
                        .append($('<th>')
                            .append($('<div>')
                                .append($('<b>').text(wrongsData[i]['question']))))))
                .append($('<tbody>')
                    .append($('<tr>')
                        .append($('<td colspan="2">')
                            .append($('<div>').attr('class', 'wrongExamples')
                                .append($('<ul>')
                                    .append($('<li>').text(wrongsData[i]['rightAnswer']))
                                    .append($('<li>').text(wrongsData[i]['example1']).attr('class', 'example_' + i + '_1'))
                                    .append($('<li>').text(wrongsData[i]['example2']).attr('class', 'example_' + i + '_2'))
                                    .append($('<li>').text(wrongsData[i]['example3']).attr('class', 'example_' + i + '_3'))
                                )
                            )
                        )
                    )
                )
            );

            for (var j = 1; j < 4; j++) {
                if (wrongsData[i]['example' + j + 'Count'] == 1) {
                    $('.example_' + i + '_' + j).css('color', 'blue');
                }
            }
        }
    }

</script>