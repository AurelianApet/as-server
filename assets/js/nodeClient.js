var socket = io.connect( 'http://localhost:3000' );

socket.on("connect", function () {
    // var from = $( "#admin" ).val();
    var from = 'admin';
    var to = $( "#user" ).val();
    socket.emit("user_connect", { name: from});
    
    $('#sendbtn').click(function () {
        // var from = $( "#admin" ).val();
        // var to = $( "#user" ).val();
        var message = $( "#message" ).val();
        socket.emit("send_message", { from: from, to: to, message: message, type: '0'});
    });
});

socket.on( 'receive_message', function( data ) {
    // var from = $( "#admin" ).val();
    var from = 'admin';
    var to = $( "#user" ).val();
    var type = '0';
    var actualContent = $( "#messages" ).html();
    var newMsgContent = '';
    
    // if (data.from == from){
    //     $('#message_li').addClass('text-right');
    // } else{
    //     $('#message_li').removeClass('text-right');
    // };

    if (data.to == from || data.from == from) {
        if (data.from == from){
            // $('#message_li').addClass('text-right');
            if (data.type == type) {
                newMsgContent = '<li style="text-align: right;"> <strong>' + data.from + '</strong> : ' + data.message + '</li>';
            }else{
                newMsgContent = '<li style="text-align: right;"> <strong>' + data.from + '</strong> : ' + '<br>' + '<img src=' + data.message + '>' + '</li>';
            };            
        } else{
            if (data.type == type) {
                newMsgContent = '<li style="text-align: left;"> <strong>' + data.from + '</strong> : ' + data.message + '</li>';
            }else{
                newMsgContent = '<li style="text-align: left;"> <strong>' + data.from + '</strong> : ' + '<br>' + '<img src=' + data.message + '>' + '</li>';
            };
        }
        // newMsgContent = '<li style="text-align: right;"> <strong>' + data.from + '</strong> : ' + data.message + '</li>';
        // if (data.from == from){
        //     newMsgContent.addClass('text-right');
        // } else{
        //     newMsgContent.removeClass('text-right');
        // }
        var content = actualContent + newMsgContent;
        $( "#messages" ).html( content );
    };
    
    // var content = actualContent + newMsgContent;
    // $( "#messages" ).html( content );
    // $('#messages').append($('<li>').text(data.name + ": " + data.message));
});