//__________________________HEADER__________________________//

$(".burger-menu").click(function() {
    $(".header-menu").toggleClass("open");
});

$(".header-menu .close").click(function() {
    $(".header-menu").removeClass("open");
});

//__________________________USERS__________________________//

$(".user-image .arrow").on("click", function(event) {
    event.preventDefault();
    event.stopPropagation();
});

//__________________________SLIDERS__________________________//

$(".img-slider").each(function() {
    var $slider = $(this);
    var $parent = $slider.closest(".user-image");

    $slider.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: $parent.find(".prev"),
        nextArrow: $parent.find(".next"),
    });
});

//_____________________SIGN-UP_LOG-IN______________________//

const popupWrapper = document.querySelector(".popUp-wrapper");
const signUpCard = document.querySelector(".signUP-card");
const logInCard = document.querySelector(".logIN-card");
const resetPasswordCard = document.querySelector(".resetPassword-card");
const loginBtn = document.querySelector(".btn.login");
const signupBtn = document.querySelector(".btn.signup");
const burgerMenu = document.querySelector(".header-burger");
const closeButtons = document.querySelectorAll(".close");
const signupLink = document.querySelector(".signup-link");
const resetPassLink = document.querySelector(".reset-pass");
const header = document.querySelector(".header");

function openPopup(card) {
    popupWrapper.classList.add("active");
    document.documentElement.classList.add("no-scroll");
    signUpCard.classList.remove("active");
    logInCard.classList.remove("active");
    resetPasswordCard.classList.remove("active");
    card.classList.add("active");
    if (window.innerWidth < 768) {
        header.classList.add("hidden");
    }
}

function closePopup() {
    popupWrapper.classList.remove("active");
    document.documentElement.classList.remove("no-scroll");
    signUpCard.classList.remove("active");
    logInCard.classList.remove("active");
    resetPasswordCard.classList.remove("active");

    header.classList.remove("hidden");
}

if (loginBtn) {
    loginBtn.addEventListener("click", () => {
        openPopup(logInCard);
    });
}

if (signupBtn) {
    signupBtn.addEventListener("click", () => {
        openPopup(signUpCard);
    });
}

if (burgerMenu) {
    burgerMenu.addEventListener("click", () => {
        openPopup(logInCard);
    });
}

if (signupLink) {
    signupLink.addEventListener("click", () => {
        openPopup(signUpCard);
    });
}

if (resetPassLink) {
    resetPassLink.addEventListener("click", () => {
        openPopup(resetPasswordCard);
    });
}

if (closeButtons) {
    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            closePopup();
        });
    });
}

if (popupWrapper) {
    popupWrapper.addEventListener("click", (event) => {
        if (!signUpCard.contains(event.target) &&
            !logInCard.contains(event.target) &&
            !resetPasswordCard.contains(event.target)
        ) {
            closePopup();
        }
    });
}

const showPasswordButtons = document.querySelectorAll(".show-password");
showPasswordButtons.forEach((button) => {
    button.addEventListener("click", function() {
        const passwordInput = $(this).siblings('[name="password"]')[0];
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.classList.add("open");
        } else {
            passwordInput.type = "password";
            this.classList.remove("open");
        }
    });
});

const enableSubmitButton = (form) => {
    if (!form) {
        return
    }

    const inputs = form.querySelectorAll(
        'input[type="email"], input[type="password"]'
    );
    const submitButton = form.querySelector(".submit.btn");

    const checkInputs = () => {
        const allFilled = Array.from(inputs).every(
            (input) => input.value.trim() !== ""
        );
        submitButton.disabled = !allFilled;
    };

    inputs.forEach((input) => {
        input.addEventListener("input", checkInputs);
    });

    checkInputs();
};

enableSubmitButton(document.querySelector(".signUP-card form"));
enableSubmitButton(document.querySelector(".logIN-card form"));
enableSubmitButton(document.querySelector(".resetPassword-card form"));

const inputs = document.querySelectorAll(".code-inputs input");

inputs.forEach((input, index) => {
    input.addEventListener("input", () => {
        if (input.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && index > 0 && input.value === "") {
            inputs[index - 1].focus();
        }
    });
});

//__________________________ADVERTISING_________________________//

document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        let popup = document.querySelector(".advertising-wrapper");
        let closeButton = document.querySelector(".advertising-close-timer");
        let timerSpan = closeButton.querySelector(".timer");
        let countdown = 5;

        popup.classList.add("show");

        let timerInterval = setInterval(function() {
            countdown--;
            timerSpan.textContent = countdown;

            if (countdown === 0) {
                clearInterval(timerInterval);
                closeButton.classList.remove("disabled");
                closeButton.classList.add("enabled");
            }
        }, 1000);

        closeButton.addEventListener("click", function() {
            if (countdown === 0) {
                popup.classList.remove("show");
            }
        });
    }, 5000);
});

//__________________________AJAX Setup_________________________//

$.ajaxSetup({
    beforeSend(xhr) {
        xhr.setRequestHeader(
            'X-CSRF-TOKEN',
            $('meta[name="csrf-token"]').attr('content')
        )
    }
})

//__________________________Loader_________________________//

function addLoader(selector) {
    $(selector).append('<div class="loader"></div>')
}

function removeLoader(selector) {
    $(selector).find('.loader').remove()
}

//__________________________Verification Code_________________________//

$('.code-inputs input').on('input', () => {
    const code = []
    $('.code-inputs input').each((i, input) => {
        if (input.value) {
            code.push(input.value)
        }
    })

    if (code.length != 6) {
        return
    }

    if ($('.verification-wrapper').hasClass('sign-up-code')) {
        verifySignUpCode(code.join(''))
    }

    if ($('.verification-wrapper').hasClass('sign-in-code')) {
        verifySignInCode(code.join(''))
    }
})

const resend = {
    timer: 60,
    interval: null,
}

function resetResend() {
    resend.timer = 60
    clearInterval(resend.interval)

    resend.interval = setInterval(() => {
        if (resend.timer < 1) {
            return
        }

        --resend.timer

        const formatted = (resend.timer - (resend.timer %= 60)) / 60 + (9 < resend.timer ? ':' : ':0') + resend.timer

        $('#countdown').text(formatted)
    }, 1000)
}

$('.again').on('click', () => {
    if (resend.timer > 0) {
        return
    }

    if ($('.verification-wrapper').hasClass('sign-up-code')) {
        resendSignUpCode()
    }

    if ($('.verification-wrapper').hasClass('sign-in-code')) {
        resendSignInCode()
    }
})

//__________________________Sign Up_________________________//

$('#sign-up').submit(function(e) {
    e.preventDefault()

    const form = $(this)
    const email = form.find('#email')
    const password = form.find('#password')
    email.closest('.input-group').removeClass('error')
    password.closest('.input-group').removeClass('error')

    addLoader('.signUP-card')

    $.post('/sign-up/send-code', form.serialize())
        .done(() => {
            const verifyPopup = $('.verification-wrapper')
            verifyPopup.find('.email').text(email.val())
            verifyPopup.addClass('sign-up-code')
            verifyPopup.addClass('active')
            $('.signUP-card').removeClass('active')
            resetResend()
        }).fail(xhr => {
            if (xhr.status != 422) {
                return
            }

            const errors = xhr.responseJSON.errors
            if (errors.email) {
                email.closest('.input-group').addClass('error')
                email.next('.error-text').text(errors.email[0])
            }

            if (errors.password) {
                password.closest('.input-group').addClass('error')
                password.next('.error-text').text(errors.password[0])
            }
        }).always(() => {
            removeLoader('.signUP-card')
        })
})

function verifySignUpCode(code) {
    addLoader('.verification-container')

    $.post('/sign-up/verify-code', { code })
        .done(() => {
            location.href = '/'
        }).always(() => {
            removeLoader('.verification-container')
        })
}

function resendSignUpCode() {
    addLoader('.verification-container')

    $.post('/sign-up/resend-code')
        .done(() => {
            resetResend()
        })
        .always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Sign In_________________________//

$('#sign-in').submit(function(e) {
    e.preventDefault()

    const form = $(this)
    const email = form.find('#email')
    const password = form.find('#password')
    email.closest('.input-group').removeClass('error')
    password.closest('.input-group').removeClass('error')

    addLoader('.logIN-card')

    $.post('/sign-in/send-code', form.serialize())
        .done(() => {
            const verifyPopup = $('.verification-wrapper')
            verifyPopup.find('.email').text(email.val())
            verifyPopup.addClass('sign-in-code')
            verifyPopup.addClass('active')
            $('.logIN-card').removeClass('active')
            resetResend()
        }).fail(xhr => {
            if (xhr.status == 401) {
                password.closest('.input-group').addClass('error')
                password.next('.error-text').text(xhr.responseJSON.message)
            }

            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors
                if (errors.email) {
                    email.closest('.input-group').addClass('error')
                    email.next('.error-text').text(errors.email[0])
                }

                if (errors.password) {
                    password.closest('.input-group').addClass('error')
                    password.next('.error-text').text(errors.password[0])
                }
            }
        }).always(() => {
            removeLoader('.logIN-card')
        })
})

function verifySignInCode(code) {
    addLoader('.verification-container')

    $.post('/sign-in/verify-code', { code })
        .done(() => {
            location.href = '/'
        }).always(() => {
            removeLoader('.verification-container')
        })
}

function resendSignInCode() {
    addLoader('.verification-container')

    $.post('/sign-in/resend-code')
        .done(() => {
            resetResend()
        })
        .always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Forgot Password_________________________//

$('#forgot-password').submit(function(e) {
    e.preventDefault()

    const form = $(this)
    const email = form.find('#reset-email')
    email.closest('.input-group').removeClass('error')

    addLoader('.resetPassword-card')

    $.post('/password/forgot', form.serialize())
        .done(() => {
            form[0].reset()
        }).fail(xhr => {
            if (xhr.status != 422) {
                return
            }

            const errors = xhr.responseJSON.errors
            if (errors.email) {
                email.closest('.input-group').addClass('error')
                email.next('.error-text').text(errors.email[0])
            }
        }).always(() => {
            removeLoader('.resetPassword-card')
        })
})

//__________________________Favorites_________________________//

$('.likes').on('click', '.btn:not(.added)', function() {
    const id = $(this).closest('.users-item').data('id')

    $(this).addClass('added')

    $.post('/favorites/add', { favorite_id: id, })
})

$('.likes').on('click', '.btn.added', function() {
    const id = $(this).closest('.users-item').data('id')

    $(this).removeClass('added')

    $.post('/favorites/remove', { favorite_id: id, })
})