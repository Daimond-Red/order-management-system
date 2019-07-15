@extends('layouts.master')

@section('pageBar')
    <div class="kt-subheader__main">
        <h3 class="kt-subheader__title"> Dashboard </h3>
        <span class="kt-subheader__separator kt-hidden"></span>
        <div class="kt-subheader__breadcrumbs">
            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link"> Dashboard </a>

            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="javascript:;" class="kt-subheader__breadcrumbs-link">Chat</a>
        </div>
    </div>
@stop

@section('style')

<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,700);

.custom-container {
  margin: 0 auto;
  background: #444753;
  border-radius: 5px;
}
.people-list {
  width: 25%;
  float: left;
}
.people-list .search {
  padding: 20px;
}
.people-list input {
  border-radius: 3px;
  border: none;
  padding: 14px;
  color: white;
  background: #6a6c75;
  width: 90%;
  font-size: 14px;
}
.people-list .fa-search {
  position: relative;
  left: -25px;
}
.people-list ul {
  padding: 20px;
  height: 500px;
}
.people-list ul li {
  padding-bottom: 20px;
  list-style:none;
}
.people-list img {
  float: left;
}
.people-list .about {
  float: left;
  margin-top: 8px;
}
.people-list .about {
  padding-left: 8px;
}
.people-list .status {
  color: #92959e;
}
.chat {
  width: 75%;
  float: left;
  background: #f2f5f8;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
  color: #434651;
  border: 1px solid #444753;
}
.chat .chat-header {
  padding: 20px;
  border-bottom: 2px solid white;
}
.chat .chat-header img {
  float: left;
}
.chat .chat-header .chat-about {
  float: left;
  padding-left: 10px;
  margin-top: 6px;
}
.chat .chat-header .chat-with {
  font-weight: bold;
  font-size: 16px;
}
.chat .chat-header .chat-num-messages {
  color: #92959e;
}
.chat .chat-header .fa-star {
  float: right;
  color: #d8dadf;
  font-size: 20px;
  margin-top: 12px;
}
.chat .chat-history {
  padding: 30px 30px 20px;
  border-bottom: 2px solid white;
  overflow-y: scroll;
  height: 345px;
}
.chat .chat-history .message-data {
  margin-bottom: 15px;
}
.chat .chat-history .message-data-time {
  color: #a8aab1;
  padding-left: 6px;
}
.chat .chat-history .message {
  color: white;
  padding: 18px 20px;
  line-height: 26px;
  font-size: 16px;
  border-radius: 7px;
  margin-bottom: 30px;
  width: 90%;
  position: relative;
}
.chat .chat-history .message:after {
  bottom: 100%;
  left: 7%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-bottom-color: #86bb71;
  border-width: 10px;
  margin-left: -10px;
}
.chat .chat-history .my-message {
  background: #86bb71;
}
.chat .chat-history .other-message {
  background: #94c2ed;
}
.chat .chat-history .other-message:after {
  border-bottom-color: #94c2ed;
  left: 93%;
}
.chat .chat-message {
  padding: 20px;
}
.chat .chat-message textarea {
  width: 100%;
  border: none;
  padding: 10px 20px;
  font: 14px/22px "Lato", Arial, sans-serif;
  margin-bottom: 10px;
  border-radius: 5px;
  resize: none;
  border:1px solid black;
}
.chat .chat-message .fa-file-o, .chat .chat-message .fa-file-image-o {
  font-size: 16px;
  color: gray;
  cursor: pointer;
}
.chat .chat-message button {
  float: right;
  color: #94c2ed;
  font-size: 16px;
  text-transform: uppercase;
  border: none;
  cursor: pointer;
  font-weight: bold;
  background: #f2f5f8;
}
.chat .chat-message button:hover {
  color: #75b1e8;
}
.online, .offline, .me {
  margin-right: 3px;
  font-size: 10px;
}
.online {
  color: #86bb71;
}
.offline {
  color: #e38968;
}
.me {
  color: #94c2ed;
}
.align-left {
  text-align: left;
}
.align-right {
  text-align: right;
}
.float-right {
  float: right;
}
.clearfix:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: " ";
  clear: both;
  height: 0;
}
li{
    list-style:none;
}
</style>


@stop

@section('content')
<div class="custom-container clearfix">
    <div class="people-list" id="people-list">
        <div class="search">
            <input type="text" placeholder="search" />
            <i class="fa fa-search"></i>
        </div>
        <ul class="list">
            <li class="clearfix">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01.jpg" alt="avatar" />
                <div class="about">
                    <div class="name">Vincent Porter</div>
                    <div class="status">
                        <i class="fa fa-circle online"></i> online
                    </div>
                </div>
            </li>
        
            <li class="clearfix">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_02.jpg" alt="avatar" />
                <div class="about">
                    <div class="name">Aiden Chavez</div>
                    <div class="status">
                        <i class="fa fa-circle offline"></i> left 7 mins ago
                    </div>
                </div>
            </li>
        </ul>
    </div>
    
    <div class="chat">
        <div class="chat-header clearfix">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01_green.jpg" alt="avatar" />
        
            <div class="chat-about">
                <div class="chat-with">Chat with Vincent Porter</div>
                <div class="chat-num-messages">already 1 902 messages</div>
            </div>
            <i class="fa fa-star"></i>
        </div> <!-- end chat-header -->
      
        <div class="chat-history">
            <ul>
                <li class="clearfix">
                    <div class="message-data align-right">
                        <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp;
                        <span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>
                      
                    </div>
                    <div class="message other-message float-right">
                        Hi Vincent, how are you? How is the project coming along?
                    </div>
                </li>
              
                <li>
                    <div class="message-data">
                        <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
                        <span class="message-data-time">10:12 AM, Today</span>
                    </div>
                    <div class="message my-message">
                        Are we meeting today? Project has been already finished and I have results to show you.
                    </div>
                </li>
              
              
              
            </ul>
        
        </div> <!-- end chat-history -->
      
        <div class="chat-message clearfix">
            <textarea name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea>
                    
            <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
            <i class="fa fa-file-image-o"></i>
            <button>Send</button>

        </div> <!-- end chat-message -->
      
    </div> <!-- end chat -->
    
  </div> <!-- end container -->

<script id="message-template" type="text/x-handlebars-template">
  <li class="clearfix">
    <div class="message-data align-right">
      <span class="message-data-time" >@{{time}}, Today</span> &nbsp; &nbsp;
      <span class="message-data-name" >Olia</span> <i class="fa fa-circle me"></i>
    </div>
    <div class="message other-message float-right">
      @{{messageOutput}}
    </div>
  </li>
</script>

<script id="message-response-template" type="text/x-handlebars-template">
  <li>
    <div class="message-data">
      <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
      <span class="message-data-time">@{{time}}, Today</span>
    </div>
    <div class="message my-message">
      @{{response}}
    </div>
  </li>
</script>

@stop

@section('script')
    <script>
        $(document).ready(function(){
            $('.booking-pending-menu').addClass('kt-menu__item--active');
        });

        (function(){
            var chat = {
                messageToSend: '',
                messageResponses: [
                    'Why did the web developer leave the restaurant? Because of the table layout.',
                    'How do you comfort a JavaScript bug? You console it.',
                    'An SQL query enters a bar, approaches two tables and asks: "May I join you?"',
                    'What is the most used language in programming? Profanity.',
                    'What is the object-oriented way to become wealthy? Inheritance.',
                    'An SEO expert walks into a bar, bars, pub, tavern, public house, Irish pub, drinks, beer, alcohol'
                ],
                init: function() {
                    this.cacheDOM();
                    this.bindEvents();
                    this.render();
                },
                cacheDOM: function() {
                    this.$chatHistory = $('.chat-history');
                    this.$button = $('button');
                    this.$textarea = $('#message-to-send');
                    this.$chatHistoryList =  this.$chatHistory.find('ul');
                },
                bindEvents: function() {
                    this.$button.on('click', this.addMessage.bind(this));
                    this.$textarea.on('keyup', this.addMessageEnter.bind(this));
                },
                render: function() {
                    this.scrollToBottom();
                    if (this.messageToSend.trim() !== '') {

                        var template = Handlebars.compile( $("#message-template").html());
                        var context = { 
                            messageOutput: this.messageToSend,
                            time: this.getCurrentTime()
                        };

                        this.$chatHistoryList.append(template(context));
                        this.scrollToBottom();
                        this.$textarea.val('');
                        //This is for save chat.
                        this.saveChat();   
                    }
                
                },
                
                addMessage: function() {
                    this.messageToSend = this.$textarea.val()
                    this.render();         
                },
                addMessageEnter: function(event) {
                    // enter was pressed
                    if (event.keyCode === 13) {
                        this.addMessage();
                    }
                },
                scrollToBottom: function() {
                    this.$chatHistory.scrollTop(this.$chatHistory[0].scrollHeight);
                },
                getCurrentTime: function() {
                    return new Date().toLocaleTimeString().
                        replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
                },
                getRandomItem: function(arr) {
                    return arr[Math.floor(Math.random()*arr.length)];
                }
                

                saveChat: function () {
                    $.ajax({
                        url : "{{ route('admin.customerChats.store') }}",
                        method : 'post',
                        data : { 'message' : this.messageToSend },
                        success : function(res) {
                            console.log(res);
                        },
                        error : function(err) {
                            console.log(err);
                        }
                    });
                }
            };
        
            chat.init();
        
            var searchFilter = {
                options: { valueNames: ['name'] },
                init: function() {
                    var userList = new List('people-list', this.options);
                    var noItems = $('<li id="no-items-found">No items found</li>');
                    
                    userList.on('updated', function(list) {
                        if (list.matchingItems.length === 0) {
                        $(list.list).append(noItems);
                        } else {
                        noItems.detach();
                        }
                    });
                }
            };
        
            searchFilter.init();
        
        })();
    </script>
@stop