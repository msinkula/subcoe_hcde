// only necessary for jquery versions before 1.7.2
(function($){
    // remove layerX and layerY
    var all = $.event.props,
        len = all.length,
        res = [];
    while (len--) {
      var el = all[len];
      if (el != 'layerX' && el != 'layerY') res.push(el);
    }
    $.event.props = res;
})(jQuery);