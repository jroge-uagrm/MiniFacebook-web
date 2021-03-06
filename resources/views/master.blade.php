<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>Mini-Facebook</title>
  <style>
    html,
    body {
      height: 100%;
    }

    a:link {
      text-decoration: none;
    }

    .btn-group-xs>.btn,
    .btn-xs {
      padding: .25rem .4rem;
      font-size: .875rem;
      line-height: .5;
      border-radius: .2rem;
    }

    .bg-gray {
      background-color: gray;
    }
  </style>
</head>

<body class="mh-100 h-100">
  @if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show col-4 mx-auto fixed-top" role="alert">
    {{session()->get('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show col-4 mx-auto fixed-top" role="alert">
    {{session()->get('error')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @section('body')
  @show

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
    crossorigin="anonymous"></script>
  <script>
    $('body').click(function () {
      $('#divmessages').hide();
      $('#divfriendrequests').hide();
    });
  </script>
  <div id="newFriendRequestAlert" class="collapse alert alert-info alert-dismissible ml-3 mb-5 col-md-3 fixed-bottom"
    role="alert">
    Tienes una nueva solicitud de amistad.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div id="newMessage" class="collapse alert alert-info alert-dismissible ml-3 mb-5 col-md-3 fixed-bottom" role="alert">
    Mensaje de: <strong id="newMessageUserNames">
    </strong>
    <div class="float-right">
      <a class="text-info font-weight-bold" id="newMessageHref" href="#">Ver</a>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div id="newComment" class="collapse alert alert-info alert-dismissible ml-3 mb-5 col-md-3 fixed-bottom" role="alert">
    <strong id="namesUserCommenter"> 
    </strong> ha comentado tu publicacion
    <div class="float-right">
      <a class="text-info font-weight-bold" id="hrefPublication" href="#">Ver</a>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div id="newFriendRequestAcceptedAlert"
    class="collapse alert alert-info alert-dismissible ml-3 mb-5  col-md-3 fixed-bottom" role="alert">
    <strong id="FriendRequestAcceptedUserNames"></strong> ha aceptado tu solicitud.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <footer class="fixed-bottom bg-dark text-white text-center">
    <?php
    $visit = 1;
    $fileName="counters/".Route::current()->getName().".txt";
    if(file_exists($fileName)) {
        $fp    = fopen($fileName, "r");
        $visit = fread($fp, 4);
        $visit++;
        fclose($fp);
    }
    $fp = fopen($fileName, "w");
    fwrite($fp, $visit);
    fclose($fp);
    ?>
    <div class="row align-items-center">
      <div class="col-4">
        <small>
          Contador de la pagina {{Route::current()->getName()}}: {{$visit}}
        </small>
      </div>
      <div class="col-4">
        <small>
          © Grupo 8 - SA
        </small>
      </div>
      <div class="col">
        <small>
          Usuarios registrados: {{count(App\User::all()->where('role_id','<>','3'))}}
        </small>
      </div>
    </div>
  </footer>
</body>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
@auth
<script>
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;
  var pusher = new Pusher('9b29f0feb3d83af18247', {
    cluster: 'us2'
  });
  var channel = pusher.subscribe('my-channel');
  channel.bind('new-message', function (data) {
    @if (Request:: is('chat/*'))
    manageMessage(data);
    @else
  var alert = document.getElementById("newMessage");
  alert.className += " show ";
  var userNames = document.getElementById("newMessageUserNames");
  var message = document.createTextNode(data.data.names);
  if (userNames.childNodes.length == 1) {
    userNames.appendChild(message);
  }
  var hrefNewMessage = document.getElementById('newMessageHref');
  hrefNewMessage.setAttribute('href', 'chat/' + data.data.senderId);
  @endif
    });
  channel.bind('friend-request', function (data) {
    if (data.data.userId == "{{ Auth:: id() }}") {
      var alert = document.getElementById("newFriendRequestAlert");
      alert.className += " show ";
    }
  });
  channel.bind('friend-request-accepted', function (data) {
    if (data.data.receiverId == "{{ Auth:: id() }}") {
      var alert = document.getElementById("newFriendRequestAcceptedAlert");
      alert.className += " show ";
      var userNames = document.getElementById("FriendRequestAcceptedUserNames");
      var message = document.createTextNode(data.data.names);
      userNames.appendChild(message);
      var hrefNewMessage = document.getElementById('FriendRequestAcceptedHref');
      hrefNewMessage.setAttribute('href', 'profile/' + data.data.senderId);
    }
  });
  channel.bind('new-comment', function (data) {
    if (data.data.receiverId == "{{ Auth:: id() }}") {
      var alert = document.getElementById("newComment");
      alert.className += " show ";
      var userNames = document.getElementById("namesUserCommenter");
      var message = document.createTextNode(data.data.names);
      userNames.appendChild(message);
      var hrefNewMessage = document.getElementById('hrefPublication');
      hrefNewMessage.setAttribute('href', 'publications/' + data.data.publicationId);
    }
  });
</script>
@endauth

</html>