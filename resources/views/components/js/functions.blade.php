<script type="text/javascript">
    const showConfirmation = ((text = 'Seguro desea realizar esta acción', title = 'Confirmación') => {
        return new Promise((resolve) => {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    resolve(true);
                } else {
                    resolve(false);
                }
            });
        })
    })

    const successSave = ((response) => {
        Swal.fire({
            title: 'Confirmación',
            html: 'El formulario ha sido guardado exitosamente',
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                    const content = Swal.getContent()
                    if (content) {
                        const b = content.querySelector('b')
                        if (b) {
                            b.textContent = Swal.getTimerLeft()
                        }
                    }
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
                window.location.reload();
            }
        })
    })

    const successDelete =((response) => {
        Swal.fire({
            title: 'Confirmación',
            html: 'El resgitro ha sido eliminado exitosamente',
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                    const content = Swal.getContent()
                    if (content) {
                        const b = content.querySelector('b')
                        if (b) {
                            b.textContent = Swal.getTimerLeft()
                        }
                    }
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
                window.location.reload();
            }
        })
    })

    const save = ((data, route, type) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: type,
                url: route,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    successSave(response); // Llama a successSave con la respuesta y el valor de redirect
                    resolve(true);
                },
                error: function(xhr, status, error) {
                    if(xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            let messages = errors[field];
                            messages.forEach(message => {
                                toastr.error(message);
                            });
                        }
                    } else {
                        toastr.error("Se produjo un error en la solicitud.");
                    }
                    resolve(false);
                }
            });
        });
    });

    const destroy = ((route) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "DELETE",
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    successDelete(response); // Llama a successSave con la respuesta y el valor de redirect
                    resolve(true);
                },
                error: function(xhr, status, error) {
                    if(xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            let messages = errors[field];
                            messages.forEach(message => {
                                toastr.error(message);
                            });
                        }
                    } else {
                        toastr.error("Se produjo un error en la solicitud.");
                    }
                    resolve(false);
                }
            });
        });
    })
</script>
