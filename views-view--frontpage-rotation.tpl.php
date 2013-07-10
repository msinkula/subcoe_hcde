<?php
// this var is magic. Don't lose it
$rotation_items = $variables["view"]->result;

?>
<div id="rotation">
    <ul class="rotation-items">
        <?php $first = true; ?>
        <?php foreach ((array)$rotation_items as $r): ?>
            <li class="rotation-item" <?php echo (!$first) ? "style=\"display: none;\"" : ""; ?>>
                <?php
                    $r_link = $r->field_field_link[0]['rendered']['#markup'];
                    $r_link_class = "";
                    $r_embed_video_link = "";
                    if (strstr($r_link, "youtube") || strstr($r_link, ("youtu.be")))
                    {
                        $r_link_class = " video";
                        $r_embed_video_link = preg_replace("/(https?:\/\/)?(www\.)?(youtu.be\/|youtube.com\/watch\?v=)([a-zA-Z\-0-9]+).*/", "http://www.youtube.com/embed/$4", $r_link);
                    }
                ?>
                <a class="rotation-link<?php echo $r_link_class; ?>" href="<?php echo $r->field_field_link[0]['rendered']['#markup']; ?>">
                    <?php echo theme_image_style(array(
                        'style_name' => 'frontpage-rotation-wide',
                        'path' => $r->field_field_image[0]['raw']['uri'],
                        'alt' => $r->node_title,
                        'title' => $r->node_title,
                        'attributes' => array()
                    )); ?>
                    <div class="slide-body-back"></div>
                    <div class="slide-body">
                        <h2><?php echo $r->node_title; ?></h2>
                        <div class="blurb">
                             <?php echo $r->field_body[0]['rendered']['#markup']; ?>
                        </div>
                    </div>
                    <?php if ($r_link_class == " video"): ?>
                        <div class="video-title" style="display: none;"><?php echo $r->node_title; ?></div>
                        <div class="video-link" style="display: none;"><?php echo $r_embed_video_link; ?></div>
                    <?php endif; ?>
                </a>
            </li>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </ul>
    <div class="rotation-thumbs">
        <?php $first = true; ?>
        <?php foreach ((array)$rotation_items as $r): ?>
            <div class="rotation-thumb <?php echo ($first) ? 'selected' : ''; ?>">
                <?php if (!empty($r->field_field_thumbnail)): ?>
                    <?php echo theme_image_style(array(
                        'style_name' => 'frontpage-rotation-thumb',
                        'path' => $r->field_field_thumbnail[0]['raw']['uri'],
                        'alt' => $r->node_title,
                        'title' => $r->node_title,
                        'width' => 40,
                        'height' => 40
                    )); ?>
                <?php else: ?>
                    <?php echo theme_image_style(array(
                        'style_name' => 'frontpage-rotation-thumb',
                        'path' => $r->field_field_image[0]['raw']['uri'],
                        'alt' => $r->node_title,
                        'title' => $r->node_title,
                        'width' => 40,
                        'height' => 40
                    )); ?>
                <?php endif; ?>
                <div class="rotation-thumb-tooltip" style="display: none;">
                    <?php echo $r->field_body[0]['rendered']['#markup']; ?>
                </div>
            </div>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </div>
</div>
<script>
    var timer;
    (function($) {

        var videoPlayerShown = false;

         timer = new Timer(function() 
        {
            var current = $("#rotation .rotation-item:visible");
            $("#rotation .rotation-thumb").eq(current.index()).removeClass('selected');

            var next = current.next();
            if (next.size() == 0)
                next = $("#rotation .rotation-item").first();
            $("#rotation .rotation-thumb").eq(next.index()).addClass('selected');

            current.fadeOut(1000);
            next.fadeIn(1000);
        }, 10000);
        timer.resume();

        // video popup
        $("#rotation a.video").click(function(e) 
        {
            e.preventDefault();
            var videoLink = $(this).find(".video-link").text();
            var videoTitle = $(this).find("h2").text();

            var video = $('<iframe />',
            {
                width: 640,
                height: 360,
                src: videoLink,
                frameborder: 0,
                allowfullscreen: 'allowfullscreen'
            }).appendTo($("#video-viewer-video").empty());

            $("#video-viewer-title").text(videoTitle);

            $("#video-viewer-pane, #video-viewer-modal").show();
            timer.disable();
            videoPlayerShown = true;
            return false;
        });

        $("html, #video-viewer-close").click(function(e)
        {
            if (videoPlayerShown && !$(e.target).is("#video-viewer, #video-viewer-title"))
            {
                e.preventDefault();
                timer.enable();
                $("#video-viewer-pane, #video-viewer-modal").hide();
                $("#video-viewer-video").empty();
                videoPlayerShown = false;
                return false;
            }
        });

        $("#rotation").mouseenter(function()
        {
            timer.pause();
        })
        .mouseleave(function()
        {
            timer.resume();
        });

        $("#rotation .rotation-thumb").click(function()
        {
            var current = $("#rotation .rotation-thumbs .selected");

            if (!$(this).is("#rotation .rotation-thumbs .selected"))
            {
                timer.reset();
                current.removeClass("selected");

                $("#rotation .rotation-item").eq(current.index()).fadeOut(1000);

                var num = $(this).addClass("selected").index();
                $("#rotation .rotation-item").eq(num).fadeIn(1000);
            }
        });

        function Timer(callback, delay) {
            var count = 0;
            var counter = 0;
            var enabled = true;

            this.pause = function() {
                if (enabled)
                    counter = 0;
            };

            this.disable = function() {
                this.pause();
                enabled = false;
            };

            this.enable = function() {
                enabled = true;
                this.resume();
            };

            this.resume = function() {
                if (enabled)
                    counter = 200;
            };

            this.reset = function() {
                if (enabled)
                    count = 0;
            };

            window.setTimeout(function()
            {
                count += counter;
                if (count == delay)
                {
                    callback();
                    count = 0;
                }
                window.setTimeout(arguments.callee, 200);
            }, 200);
                
        }

    })(jQuery);
</script>