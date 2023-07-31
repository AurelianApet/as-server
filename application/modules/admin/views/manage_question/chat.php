<script src="<?= base_url('assets/js/node_modules/socket.io-client/dist/socket.io.js') ?>"></script>
<script src="<?= base_url('assets/js/nodeClient.js') ?>"></script>

<div id="chat_histories">
    <input type="hidden" value="<?= $admin ?>" id="admin">                       
    <input type="hidden" value="<?= $user['name'] ?>" id="user">                       
    <ul id="messages" name="messages">
        <!-- <li id="message_li"></li> -->
    </ul>
    <div id="messageDiv" name="messageDiv" style="position: fixed; width: 90%; bottom: 10px;">
        <input autocomplete="off" style="font-size: 16px; width: 90%; padding: 5px" placeholder="type your message here..." type="text" value="" id="message" name="message">                       
        <button class="text-right" type="" style="position:absolute; margin-left: -45px; z-index: 3; padding-top: 1px; padding-bottom: 1px;" value="" id="sendbtn">
        	<img src="<?= base_url('assets/imgs/chat_send.png') ?>" style="height: 30px; ">
        </button>
    </div>
</div>
