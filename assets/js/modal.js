"use strict";

export default function createModal(message, id = null, askForConfirmation = false) {
  let uniqid = id || (new Date().getTime()).toString(16);
  let actions;
  if(askForConfirmation){
    actions = `
      <a href="#!" class="modal-action confirm modal-close waves-effect waves-green btn-flat">Oui</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Non</a>`
    ;
  }
  else {
    actions = `
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fermer</a>`
    ;
  }

  let template = `
    <div id="${uniqid}" class="modal">
        <div class="modal-content">
        ${message}
        </div>
        <div class="modal-footer">
        ${actions}
        </div>
    </div>
  `;

  $('body').append(template);

  $('.modal').modal();

  $(`#${uniqid}`).modal('open');
}

export {createModal};
