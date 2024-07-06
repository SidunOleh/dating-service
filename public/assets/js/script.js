Fancybox.bind("[data-fancybox]", {});

//__________________________HEADER__________________________//

$(".burger-menu").click(function () {
  $(".header-menu").toggleClass("open");
});

$(".header-menu .close").click(function () {
  $(".header-menu").removeClass("open");
});

//__________________________USERS-CARD__________________________//

$(".user-image .arrow").on("click", function (event) {
  event.preventDefault();
  event.stopPropagation();
});

//__________________________SLIDERS__________________________//

$(".img-slider").each(function () {
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

$(document).ready(function () {
    const $popupWrapper = $(".popUp-wrapper");
    const $header = $(".header");
    const $cards = {
      signUp: $(".signUP-card"),
      logIn: $(".logIN-card"),
      resetPassword: $(".resetPassword-card"),
    };
  
    function togglePopup(cardName, show) {
      const $card = $cards[cardName];
      $popupWrapper.toggleClass("active", show);
      $("html").toggleClass("no-scroll", show);
      $header.toggleClass("hidden", show && $(window).width() < 768);
  
      Object.values($cards).forEach(($c) => $c.removeClass("active"));
      if (show) $card.addClass("active");
    }
  
    $(".btn.login, .header-burger").on("click", () => togglePopup("logIn", true));
    $(".btn.signup, .signup-link").on("click", () => togglePopup("signUp", true));
    $(".reset-pass").on("click", () => togglePopup("resetPassword", true));
    $(".close").on("click", () => togglePopup("", false));
  
    // $popupWrapper.on("click", function (event) {
    //   if (
    //     !$(event.target).closest(".signUP-card, .logIN-card, .resetPassword-card")
    //       .length
    //   ) {
    //     togglePopup("", false);
    //   }
    // });
  
    $(".show-password").on("click", function () {
      const $passwordInput = $(this).closest(".input-group").find("input");
      const isPassword = $passwordInput.attr("type") === "password";
      $passwordInput.attr("type", isPassword ? "text" : "password");
      $(this).toggleClass("open", isPassword);
    });
  
    function enableSubmitButton($form) {
      const $inputs = $form.find('input[type="email"], input[type="password"]');
      const $submitButton = $form.find(".submit.btn");
  
      const checkInputs = () => {
        const allFilled = $inputs
          .toArray()
          .every((input) => $(input).val().trim() !== "");
        $submitButton.prop("disabled", !allFilled);
      };
  
      $inputs.on("input", checkInputs);
      checkInputs();
    }
  
    $(".signUP-card form, .logIN-card form, .resetPassword-card form").each(
      function () {
        enableSubmitButton($(this));
      }
    );
  
    $(".code-inputs input").each(function (index, input) {
      $(input)
        .on("input", function () {
          if (
            this.value.length === 1 &&
            index < $(".code-inputs input").length - 1
          ) {
            $(".code-inputs input")
              .eq(index + 1)
              .focus();
          }
        })
        .on("keydown", function (e) {
          if (e.key === "Backspace" && index > 0 && this.value === "") {
            $(".code-inputs input")
              .eq(index - 1)
              .focus();
          }
        });
    });
  });

//__________________________AJAX Setup_________________________//

$.ajaxSetup({
    beforeSend: (xhr) => xhr.setRequestHeader(
        'X-CSRF-TOKEN', 
        $('meta[name="csrf-token"]').attr('content')
    ) 
})

//__________________________ADVERTISING_________________________//

if (DS && DS.ads?.data && DS.ads?.settings) {
    const adPopup = {
        counters: {
            secs: 0,
            clicks: 0,
        },
        next: null,
        showing: false,
        get secsCount() {
            return this.counters.secs
        },
        set secsCount(count) {
            if (this.showing) {
                return
            }

            if (count >= parseInt(DS.ads.settings.seconds_between_popups)) {
                this.showing = true
                this.counters.secs = 0
                this.counters.clicks = 0
                this.show()
            } else {
                this.counters.secs = count
            }
        },
        get clicksCount() {
            return this.counters.clicks
        },
        set clicksCount(count) {
            if (this.showing) {
                return
            }

            if (count >= parseInt(DS.ads.settings.clicks_between_popups)) {
                this.showing = true
                this.counters.secs = 0
                this.counters.clicks = 0
                this.show()
            } else {
                this.counters.clicks = count
            }
        },
        show() {
            if (! this.next) {
                return
            }

            const popup = $('.advertising-wrapper')
            const img = $('.advertising-img')
            const link = $('.advertising-link')
    
            img.attr('src', this.next.image.url)
            link.data('id', this.next.id)
            link.attr('href', this.next.link)

            adCloseTimer.start(DS.ads.settings.close_popup_seconds)

            popup.addClass('show')

            this.getNext()
        },
        hide() {
            this.showing = false
            $('.advertising-wrapper').removeClass('show')
        },
        getNext() {
            if (! DS.ads.data.length) {
                return
            }

            const min = 0
            const max = DS.ads.data.length - 1
            const rand = Math.floor(Math.random() * (max - min + 1)) + min

            this.next = DS.ads.data[rand]
            this.predownloadNextImage()
        },
        predownloadNextImage() {
            const image = new Image 
            image.src = this.next.image.url 
        },
        ini() {
            this.getNext()

            $('.advertising-wrapper').on('click', '.advertising-close-timer.enabled', () => {
                this.hide()
            })
        
            $('.users-item.profile-item').on('click auxclick', () => {
                this.clicksCount += 1
            })
        
            setInterval(() => {
                this.secsCount += 1
            }, 1000)
        },
    }

    const adCloseTimer = {
        secs: 0,
        interval: null,
        start(secs) {
            const close = $('.advertising-close-timer')
            close.removeClass('enabled')
            close.addClass('disabled')

            const timer = $('.advertising-close-timer .timer')
            timer.text(secs)

            this.secs = secs

            this.interval = setInterval(() => {
                this.secs--

                timer.text(this.secs)

                if (this.secs <= 0) {
                    close.addClass('enabled')
                    close.removeClass('disabled')
                    clearInterval(this.interval)
                }
            }, 1000)
        }
    }

    adPopup.ini()
}

$('.advertising-link, .advertising-banner, .users-item.add').on('auxclick click', function () {
    const id = $(this).data('id')

    $.post(`/ads/${id}/click`)
})

//__________________________Loader_________________________//

function addLoader(selector) {
    $(selector).append('<div class="loader"></div>')
}

function removeLoader(selector) {
    $(selector).find('.loader').remove()
}

//__________________________Verification Code_________________________//

const resendTimer = {
    secs: 0,
    interval: null,
    start(secs) {
        this.secs = secs
    
        this.interval = setInterval(() => {    
            --this.secs
    
            const formatted = (this.secs - (this.secs %= 60)) / 60 + (9 < this.secs ? ':' : ':0') + this.secs
            $('#countdown').text(formatted)

            if (this.secs <= 0) {
                clearInterval(this.interval)
            }
        }, 1000)
    },
}

$('input').on('paste', function (e) {
    e.preventDefault()

    const inputs = $('.code-inputs input')

    let code = (e.originalEvent.clipboardData || window.clipboardData).getData('text')
    code = code.split('')
    code.forEach((number, i) => $(inputs[i]).val(number))
})

$('.verification-wrapper .code-inputs input').on('input paste', () => {
    const code = []
    $('.code-inputs input').each((i, input) => {
        if (input.value) {
            code.push(input.value)
        }
    })

    if (code.length != 6) {
        return
    }

    if ($('.verification-wrapper').data('action') == 'sign-up') {
        verifySignUpCode(code.join(''))
    }

    if ($('.verification-wrapper').data('action') == 'sign-in') {
        verifySignInCode(code.join(''))
    }
})

$('.verification-wrapper .again').on('click', () => {
    if (resendTimer.secs > 0) {
        return
    }

    if ($('.verification-wrapper').data('action') == 'sign-up') {
        resendSignUpCode()
    }

    if ($('.verification-wrapper').data('action') == 'sign-in') {
        resendSignInCode()
    }
})

//__________________________Sign Up_________________________//

$('#sign-up').submit(function(e) {
    e.preventDefault()
    
    addLoader('.signUP-card')

    const form = $(this)
    const email = form.find('#email')
    const password = form.find('#password')
    email.closest('.input-group').removeClass('error')
    password.closest('.input-group').removeClass('error')

    $.post('/sign-up/send-code', form.serialize())
        .done(() => {
            const verifyPopup = $('.verification-wrapper')
            verifyPopup.find('.email').text(email.val())
            verifyPopup.data('action', 'sign-up')
            verifyPopup.addClass('active')
            $('.signUP-card').removeClass('active')
            resendTimer.start(60)
        }).fail(xhr => {
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
            } else {
                alert(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.signUP-card')
        })
})

function verifySignUpCode(code) {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    $.post('/sign-up/verify-code', { code })
        .done(() => {
            location.reload()
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

function resendSignUpCode() {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    $.post('/sign-up/resend-code')
        .done(() => {
            resendTimer.start(60)
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Sign In_________________________//

$('#sign-in').submit(function(e) {
    e.preventDefault()

    addLoader('.logIN-card')

    const form = $(this)
    const email = form.find('#email')
    const password = form.find('#password')
    email.closest('.input-group').removeClass('error')
    password.closest('.input-group').removeClass('error')

    $.post('/sign-in/send-code', form.serialize())
        .done(() => {
            const verifyPopup = $('.verification-wrapper')
            verifyPopup.find('.email').text(email.val())
            verifyPopup.data('action', 'sign-in')
            verifyPopup.addClass('active')
            $('.logIN-card').removeClass('active')
            resendTimer.start(60)
        }).fail(xhr => {
            if (xhr.status == 401) {
                password.closest('.input-group').addClass('error')
                password.next('.error-text').text(xhr.responseJSON.message)
            } else if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors

                if (errors.email) {
                    email.closest('.input-group').addClass('error')
                    email.next('.error-text').text(errors.email[0])
                }

                if (errors.password) {
                    password.closest('.input-group').addClass('error')
                    password.next('.error-text').text(errors.password[0])
                }
            } else {
                alert(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.logIN-card')
        })
})

function verifySignInCode(code) {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    $.post('/sign-in/verify-code', { code })
        .done(() => {
            location.reload()
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

function resendSignInCode() {
    addLoader('.verification-container')

    const codeForm = $('.code-inputs')
    codeForm.removeClass('error')
    const codeError = codeForm.find('.error-text')
    codeError.text('')

    $.post('/sign-in/resend-code')
        .done(() => {
            resendTimer.start(60)
        }).fail(err => {
            codeForm.addClass('error')
            codeError.text(err.responseJSON.message)
        }).always(() => {
            removeLoader('.verification-container')
        })
}

//__________________________Forgot Password_________________________//

$('#forgot-password').submit(function(e) {
    e.preventDefault()

    addLoader('.resetPassword-card')

    const form = $(this)
    const email = form.find('#reset-email')
    email.closest('.input-group').removeClass('error')

    $.post('/password/forgot', form.serialize())
        .done(() => {
            form[0].reset()
        }).fail(xhr => {
            if (xhr.status == 422) {
                const errors = xhr.responseJSON.errors
                
                if (errors.email) {
                    email.closest('.input-group').addClass('error')
                    email.next('.error-text').text(errors.email[0])
                }
            } else {
                alert(xhr.responseJSON.message)
            }
        }).always(() => {
            removeLoader('.resetPassword-card')
        })
})

//__________________________Favorites_________________________//

$('.likes').on('click', '.btn:not(.active)', function(e) {
    e.preventDefault()
    e.stopPropagation()

    $(this).addClass('active')
    const likes = $(this)
        .closest('.likes')
        .find('.likes-count')
    likes.text(parseInt(likes.text()) + 1)

    const id = $(this).closest('.likes').data('id')

    $.post('/favorites/add', { favorite_id: id, }).fail(() => {
        $(this).removeClass('active')
        likes.text(parseInt(likes.text()) - 1)
    })
})

$('.likes').on('click', '.btn.active', function(e) {
    e.preventDefault()
    e.stopPropagation()

    $(this).removeClass('active')
    const likes = $(this)
        .closest('.likes')
        .find('.likes-count')
    likes.text(parseInt(likes.text()) - 1)

    const id = $(this).closest('.likes').data('id')

    $.post('/favorites/remove', { favorite_id: id, }).fail(() => {
        $(this).addClass('active')
        likes.text(parseInt(likes.text()) + 1)
    })
})

//__________________________Filters_________________________//

$('#filters-form').submit(function() {
    $(this).find('input[name]')
        .filter((i, input) => !input.value)
        .prop('name', '')
})
