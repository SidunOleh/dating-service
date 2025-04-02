<div class="btn red meow" data-step="0">
    Play ;D
</div>

<script>
    const meowText = [
        'Play ;D',
        '14',
        '13',
        'noon',
        '11',
        '10',
        'MORE !!!',
        '8',
        '007',
        'moree??',
        '50%',
        '4',
        '3',
        '2',
        '1',
        '0',
        '-1 ;D',
        'secret',
        'more!',
        '-4',
        'doNe',
    ]

    const meowAudio = [
        '/assets/meow/1.mp3',
        '/assets/meow/2.mp3',
        '/assets/meow/3.mp3',
        '/assets/meow/4.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
        '/assets/meow/1.mp3',
    ]

    new Audio(meowAudio[0])

    window.onload = () => {
        $('.meow.btn').on('click', function () {
            const step = Number($(this).data('step')) + 1

            if (step <= 20) {
                $(this).text(meowText[step])

                new Audio(meowAudio[step]).play()
                if (meowAudio[step+1]) {
                    new Audio(meowAudio[step+1])
                }

                if (step == 20) {
                    location.href = '/faq'
                }
            } 

            $(this).data('step', step)
        })
    }
</script>