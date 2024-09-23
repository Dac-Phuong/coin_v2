// update

document.addEventListener("livewire:navigated", function () {
  initFlowbite();
  $(".modal-backdrop.show").remove();
  const modal = document.querySelector("#kt_modal_update");

  if (modal) {
    modal.addEventListener("show.bs.modal", (e) => {
      $(".modal-backdrop.show").remove();
      Livewire.dispatch("update", {
        id: e.relatedTarget.getAttribute("data-id"),
        coin_id: e.relatedTarget.getAttribute("data-coin-id"),
      });
    });
  }
        

});
document.addEventListener("livewire:navigated", function () {
  initFlowbite();
  $(".modal-backdrop.show").remove();
  const modal = document.querySelector("#kt_modal_show");
  if (modal) {
    modal.addEventListener("show.bs.modal", (e) => {
      $(".modal-backdrop.show").remove();
      Livewire.dispatch("update", {
        id: e.relatedTarget.getAttribute("data-id"),
      });
    });
  }
});
document.addEventListener("livewire:navigated", function () {
  initFlowbite();
  $(".modal-backdrop.show").remove();
  const modal = document.querySelector("#kt_modal_add_profit");
  if (modal) {
    modal.addEventListener("show.bs.modal", (e) => {
      $(".modal-backdrop.show").remove();
      Livewire.dispatch("update", {
        id: e.relatedTarget.getAttribute("data-id"),
      });
    });
  }
});
document.addEventListener("livewire:navigated", function () {
  $(".modal-backdrop.show").remove();
  const modal = document.querySelector("#kt_modal_update1");
  if (modal) {
    modal.addEventListener("show.bs.modal", (e) => {
      $(".modal-backdrop.show").remove();
      Livewire.dispatch("update", {
        id: e.relatedTarget.getAttribute("data-id"),
        
      });
    });
  }

});

document.addEventListener("livewire:navigated", function () {
  $(".modal-backdrop.show").remove();
  const modal = document.querySelector("#kt_modal_deposit");
  if (modal) {
    modal.addEventListener("show.bs.modal", (e) => {
      $(".modal-backdrop.show").remove();
      Livewire.dispatch("update", {
        id: e.relatedTarget.getAttribute("data-id"),
        
      });
    });
  }

});

document.addEventListener("livewire:init", function () {
  Livewire.on("success", function (success) {
    $("#kt_modal_add").modal("hide");
    $("#kt_modal_add_profit").modal("hide");
    $("#kt_modal_update").modal("hide");
    $("#kt_modal_add_wallet").modal("hide");
    $('#kt_modal_update').modal({
      backdrop: false
    });
    toastr.options = {
      closeButton: true,
      progressBar: true,
    };
    toastr.success(success);
  });

  $("#kt_modal_add, #kt_modal_update").on("hide.bs.modal", function (e) {
    $("body").addClass("modal-open");
  });
});
document.addEventListener("livewire:init", function () {
  Livewire.on("error", function (error) {
    toastr.options = {
      closeButton: true,
      progressBar: true,
    };
    toastr.error(error);
  });
});
