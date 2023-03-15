$(function($) {
  const _url = window.location.origin,
        _token = $(':input[name=_token]').val(),
        userPermission = JSON.parse(localStorage.getItem('userPermission'));

  $('button[name=btnSave], button[name=btnFilter]').on('click', function(e) {
    CreateLoading();
  });
});
