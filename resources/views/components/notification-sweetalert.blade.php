@if ($event.detail.status === 'success')
<div x-data="{ open: false }" x-show="open"
@notify.window="swal.fire({
    position: 'top-end',
    icon: $event.detail.status,
    title: $event.detail.title,
    showConfirmButton: false,
    timer: 1500
});">

</div>
@endif


{{-- <div x-data="{ open: false }" x-show="open"
    @notifySuccess.window="Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Something went wrong!'
    });">

</div> --}}
