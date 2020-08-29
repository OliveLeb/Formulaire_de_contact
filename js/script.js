/*window.addEventListener('load', function () {
  const submitForm = document.querySelector('#contact-form');
  submitForm.addEventListener('submit', function (e) {
    e.preventDefault();
    let commentError = document.querySelectorAll('.comments');

    for (let i = 0; i < commentError.length; i++) {
      if (commentError[i].firstChild) {
        //console.log(commentError[i].firstChild);
        commentError[i].removeChild(commentError[i].firstChild);
      }
    }

    const form = document.querySelector('#contact-form').value;
    const postData = new FormData(form);
    console.log(form);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/contact.php');
    xhr.send(postData.value);
    /*
    $.ajax({
      type: 'POST',
      url: 'php/contact.php',
      data: postData,
      dataType: 'json',
      succes: function (result) {
        if (result.isSuccess) {
          const paragraphe = document.createElement('p');
          paragraphe.className = 'thank-you';
          const remerciement = document.createTextNode(
            "Votre message a bien été envoyé. Merci de m'avoir contacté !&#128512"
          );
          paragraphe.appendChild(remerciement);
          //const paragrapheSuivant = document.querySelector('#cheat');
          const row = document.querySelector('#row');
          row.insertAdjacentElement('afterend', paragraphe);
          // document.body.insertBefore;

          submitForm.reset();
        } else {
          const firstname = document.querySelector('#firstname');
          const name = document.querySelector('#name');
          const email = document.querySelector('#email');
          const phone = document.querySelector('#phone');
          const message = document.querySelector('#message');

          let commentFirstname = firstname.nextElementSibling;
          commentFirstname.innerHTML(result.firstnameError);

          let commentName = name.nextElementSibling;
          commentName.innerHTML(result.nameError);

          let commentEmail = email.nextElementSibling;
          commentEmail.innerHTML(result.emailError);

          let commentPhone = phone.nextElementSibling;
          commentPhone.innerHTML(result.phoneError);

          let commentMessage = message.nextElementSibling;
          commentMessage.innerHTML(result.messageError);
        }
      },
    });
  });
});*/

$(function () {
  $('#contact-form').submit(function (e) {
    e.preventDefault();
    $('.comments').empty();
    var postdata = $('#contact-form').serialize();

    $.ajax({
      type: 'POST',
      url: 'php/contact.php',
      data: postdata,
      dataType: 'json',
      success: function (result) {
        if (result.isSuccess) {
          $('#contact-form').append(
            "<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté ! &#128512;</p>"
          );
          $('#contact-form')[0].reset();
        } else {
          $('#firstname + .comments').html(result.firstnameError);
          $('#name + .comments').html(result.nameError);
          $('#email + .comments').html(result.emailError);
          $('#phone + .comments').html(result.phoneError);
          $('#message + .comments').html(result.messageError);
        }
      },
    });
  });
});
