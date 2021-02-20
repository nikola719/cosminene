/**
 * This is script for index page
 */
(function ($) {
  let old_youtube;
  $(window).on("load", function () {
    if ($(".movie-youtube")) {
      old_youtube = $(".movie-youtube").attr("src");
    }
  });

  $(document).ready(function () {
    var pod_playing = false;
    var carousel_playing = false;
    // Wow init
    new WOW().init();
    $(document).on("click", ".hamburger", function () {
      $(this).toggleClass("active");
      $(".header").toggleClass("active");
      if ($(".header").hasClass("active")) {
        $("html,body").css("overflow-y", "hidden");
      } else {
        $("html, body").css("overflow-y", "visible");
      }
    });

    //viewport check
    $.fn.isInViewport = function () {
      if ($(this).length > 0) {
        let elementTop = $(this).offset().top;
        let elementBottom = elementTop + $(this).outerHeight();

        let viewportTop = $(window).scrollTop();
        let viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
      }
    };

    //scroll effect
    var lastScrollTop = 0;
    $(window).scroll(function (event) {
      var st = $(this).scrollTop();
      if (st > lastScrollTop && st > $(".header").outerHeight()) {
        // downscroll code
        if (!$(".header").hasClass("active")) {
          $(".header").addClass("is-hidden");
        }
      }
      if (st < lastScrollTop && st < 800) {
        // upscroll code
        $(".header").removeClass("is-hidden");
      }

      if ($(".article-content__statistics").isInViewport()) {
        $(".article-content__statistics").addClass("active");
      } else {
        $(".article-content__statistics").removeClass("active");
      }
      lastScrollTop = st;
    });

    //filter select
    // $(document).on("click", ".artint-filter__item", function () {

    // });

    //playing podcast in carousel
    $(document).on(
      "click",
      ".podcast-carousel__details .start-play",
      { passive: true },
      function (e) {
        // switch the screen
        $(this)
          .closest(".podcast-carousel__container")
          .find(".podcast-carousel__single")
          .removeClass("active");
        $(this).closest(".podcast-carousel__single").addClass("active");
        //youtube autoplay according to play button click event
        if ($(".movie-youtube")) {
          const timestamp = $(this).parent().attr("timestamp");
          let new_youtube = old_youtube + "?start=" + timestamp + "&autoplay=1";
          $(".movie-youtube").attr("src", new_youtube);
        }
        //podcast play
        if (
          $(this).closest(".podcast-carousel__single").find("audio").length > 0
        ) {
          $(this)
            .closest(".podcast-carousel__container")
            .find("audio")
            .each(function () {
              $(this).get(0).pause();
              carousel_playing = false;
            });

          $(this)
            .closest(".podcast-carousel__single")
            .find(".image-wrapper audio")
            .get(0)
            .play();
          carousel_playing = true;
        }
      }
    );

    //stop playing podcast in carousel
    $(document).on(
      "click",
      ".podcast-carousel__details .start-stop",
      function (e) {
        e.stopPropagation();
        $(this)
          .closest(".podcast-carousel__container")
          .find(".podcast-carousel__single")
          .removeClass("active");
        if ($(".movie-youtube").length > 0) {
          $(".movie-youtube").attr("src", "");
          $(".movie-youtube").attr("src", old_youtube);
        } else {
          $(this)
            .closest(".podcast-carousel__single")
            .find("audio")
            .get(0)
            .pause();
          carousel_playing = false;
        }
      }
    );
    $(".podcast-carousel__container audio").each(function () {
      $(this).on("ended", function () {
        carousel_playing = false;
        $(this).closest(".podcast-carousel__single").removeClass("active");
      });
    });

    //play podcast upon click event in video-podcast page
    $(document).on("click", ".episode-img__container", function (e) {
      e.stopPropagation();
      $(this).toggleClass("active");
      if (pod_playing == false) {
        $(".episode-featured__podcast").get(0).play();
        pod_playing = true;
      } else {
        $(".episode-featured__podcast").get(0).pause();
        pod_playing = false;
      }
    });
    //podcast end
    $(".episode-featured__podcast").on("ended", function () {
      $(this).closest(".episode-img__container").removeClass("active");
    });

    // play and pause podcast upon click event in single podcast page
    $("body").on("click", ".meta-play", function (e) {
      e.stopPropagation();
      $(this)
        .closest(".article-meta")
        .find(".article-meta__player")
        .addClass("active");
      $(this).closest(".article-meta").find("audio").get(0).play();
    });

    $("body").on("click", ".meta-stop", function (e) {
      e.stopPropagation();
      $(this)
        .closest(".article-meta")
        .find(".article-meta__player")
        .removeClass("active");
      $(this).closest(".article-meta").find("audio").get(0).pause();
    });

    //progressbar customization
    $(".article-meta audio").bind("timeupdate", function () {
      var currentTime = $(this).get(0).currentTime;
      var duration = $(this).get(0).duration;
      var increment = 10 / duration;
      var percent = Math.min(increment * currentTime * 10, 100);
      $(this)
        .closest(".article-meta")
        .find(".progress")
        .css("width", percent + "%");
      $(this)
        .closest(".article-meta")
        .find(".cursor")
        .css("left", percent + "%");
    });

    //podcast end
    $(".article-meta audio").on("ended", function () {
      $(this)
        .closest(".article-meta")
        .find(".article-meta__player")
        .removeClass("active");
      $(this).closest(".article-meta").find(".progress").css("width", 0);
      $(this).closest(".article-meta").find(".cursor").css("left", 0);
    });

    // Initialize form validation on the registration form.
    if ($("form[name='contact']").length > 0) {
      $(function () {
        $("form[name='contact']").validate({
          rules: {
            fullname: "required",
            email: {
              required: true,
              email: true,
            },
            message: "required",
          },
          // Specify validation error messages
          messages: {
            fullname: "Please enter your name",
            message: "Please enter your message",
            email: "Please enter a valid email address",
          },
          // Make sure the form is submitted to the destination defined
          // in the "action" attribute of the form when valid
          submitHandler: function (form) {
            form.submit();
          },
        });
      });
    }
    //Slick Carousel
    if ($(".podcast-carousel").length) {
      $(".podcast-carousel .podcast-carousel__container").slick({
        arrows: true,
        cssEase: "ease",
        easing: "linear",
        autoplay: false,
        infinite: true,
        autoplaySpeed: 3000,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 1199,
            settings: {
              slidesToShow: 3,
            },
          },
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
            },
          },
          {
            breakpoint: 640,
            settings: {
              slidesToShow: 1,
            },
          },
        ],
      });
      blog_posts_height_adjust();
      $(window).on("resize", function () {
        blog_posts_height_adjust();
      });
    }
    function blog_posts_height_adjust() {
      var max_height = 0;
      $(".podcast-carousel__container .podcast-carousel__single").each(
        function () {
          if (max_height < $(this).height()) {
            max_height = $(this).height();
          }
        }
      );
      $(".podcast-carousel__container .podcast-carousel__single").each(
        function () {
          $(this).height(max_height);
        }
      );
    }

    //Load more posts
    $("body").on("click", ".artint-more__link", function (e) {
      let categories = [];
      let filterWrapper = $(this)
        .closest(".container")
        .find(".artint-filter__items .artint-filter__item");
      for (let i = 0; i < filterWrapper.length; i++) {
        if ($(filterWrapper[i]).hasClass("filtered")) {
          categories.push($(filterWrapper[i]).find("span").html());
        }
      }
      let postType = $(this).attr("post-type");
      let postNotIn = $(this).attr("post-not-in");
      blog_ajax_call(postType, categories.toString(), postNotIn);
    });

    //filter categories
    $("body").on("click", ".artint-filter__item", function (e) {
      $(this).toggleClass("filtered");
      let categories = [];
      let filterWrapper = $(this)
        .closest(".artint-filter__items")
        .find(".artint-filter__item");
      for (let i = 0; i < filterWrapper.length; i++) {
        if ($(filterWrapper[i]).hasClass("filtered")) {
          const data = $(filterWrapper[i]).find("span").html();
          categories.push(data);
        }
      }
      let postType = $(".artint-more__link").attr("post-type");
      let postNotIn = $(".artint-read:first").attr("post-id");
      filter_ajax_call(postType, categories.toString(), postNotIn);
    });
  });

  function blog_ajax_call(postType, categories, postNotIn) {
    $.ajax({
      url: ajaxurl,
      type: "post",
      dataType: "json",
      data: {
        action: "load-more-blog",
        post_type: postType,
        posts_not_in: postNotIn,
        category: categories,
      },
      success: function (data) {
        $(".artint-more__link").attr("post-not-in", data.post_not_in);
        var blog = $(".artint .artint-read:last");
        $(blog).after(data.res);
        setTimeout(function () {
          $(".warning-post").fadeOut();
        }, 3000);
      },
      error: function (errorThrown) {
        console.log(errorThrown);
      },
    });
  }

  function filter_ajax_call(postType, categories, postNotIn) {
    $.ajax({
      url: ajaxurl,
      type: "post",
      dataType: "json",
      data: {
        action: "load-filter-blog",
        post_type: postType,
        posts_not_in: postNotIn,
        category: categories,
      },
      success: function (data) {
        $(".artint-more__link").attr("post-not-in", data.post_not_in);
        if (data.post_type != "videos") {
          $(".artint").find(".artint-read:not(:eq(0))").remove();
          $(".artint-read").after(data.res);
        } else {
          $(".artint").find(".artint-read").remove();
          $(".artint-filter").after(data.res);
        }
        setTimeout(function () {
          $(".warning-post").fadeOut();
        }, 3000);
      },
      error: function (errorThrown) {
        console.log(errorThrown);
      },
    });
  }
})(jQuery);
