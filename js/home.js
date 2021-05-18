// BULLE
/////////////////////////////////////////
// Some random colors
const colors = ["#3CC157", "#2AA7FF", "#f17f7f", "#FCBC0F", "#F85F36"];

const numBalls = 50;
const balls = [];

for (let i = 0; i < numBalls; i++) {
    let ball = document.createElement("div");
    ball.classList.add("ball");
    ball.style.background = colors[Math.floor(Math.random() * colors.length)];
    ball.style.left = `${Math.floor(Math.random() * 90)}vw`;
    ball.style.top = `${Math.floor(Math.random() * 90)}vh`;
    ball.style.transform = `scale(${Math.random()})`;
    ball.style.width = `${Math.random()}em`;
    ball.style.height = ball.style.width;

    balls.push(ball);
    document.body.append(ball);
}

// Keyframes
balls.forEach((el, i, ra) => {
    let to = {
        x: Math.random() * (i % 2 === 0 ? -11 : 11),
        y: Math.random() * 12
    };

    let anim = el.animate(
        [
            { transform: "translate(0, 0)" },
            { transform: `translate(${to.x}rem, ${to.y}rem)` }
        ],
        {
            duration: (Math.random() + 1) * 2000, // random duration
            direction: "alternate",
            fill: "both",
            iterations: Infinity,
            easing: "ease-in-out"
        }
    );
});

///////////////////
////POP UP LOGIN

(function(){
    $('html').addClass('js');
    // $("html").addClass("blur-filter");


    var contactForm = {
        container: $('#popup_login'),
        config: {
            effect: 'slideToggle',
            speed: 200
        },

        init: function(config){
            $.extend(this.config, config);
            $('#login').on('click', this.show);

        },

        show: function(){
            var cf = contactForm,
                container = cf.container,
                config = cf.config;

            if(container.is(':hidden')){
                $("#main").addClass("blur-filter");

                cf.close.call(container);
                container[config.effect]
                (config.speed);
            }

        },

        close: function(){
            var $this = $('#popup_login');
            if($this.find('span.close').length) return;

            $('<span class=close>x</span>')
                .prependTo(this)
                .on('click', function(){
                    $this[contactForm.config.effect](contactForm.config.speed);
                    $(".blur-filter").removeClass("blur-filter");
                });

        }
    };

    contactForm.init({
        effect: 'fadeToggle',
        speed: 200

    });
})();

///////////////////
////POP UP REGISTER

(function(){
    $('html').addClass('js2');
    // $("html").addClass("blur-filter");


    var contactForm = {
        container: $('#popup_register'),
        config: {
            effect: 'slideToggle',
            speed: 200
        },

        init: function(config){
            $.extend(this.config, config);
            $('#register').on('click', this.show);

        },

        show: function(){
            var cf = contactForm,
                container = cf.container,
                config = cf.config;

            if(container.is(':hidden')){
                $("#main").addClass("blur-filter");

                cf.close.call(container);
                container[config.effect]
                (config.speed);
            }

        },

        close: function(){
            var $this = $('#popup_register');
            if($this.find('span.close').length) return;

            $('<span class=close>x</span>')
                .prependTo(this)
                .on('click', function(){
                    $this[contactForm.config.effect](contactForm.config.speed);
                    $(".blur-filter").removeClass("blur-filter");
                });

        }
    };

    contactForm.init({
        effect: 'fadeToggle',
        speed: 200

    });
})();
