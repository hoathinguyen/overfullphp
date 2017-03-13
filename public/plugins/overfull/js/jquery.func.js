/**
 * Remove element with effect
 * @param {type} setting
 * @returns {undefined}
 */
$.fn.removeWithEffect = function(setting){
    if(setting == undefined || setting == null)
        setting = {};
    
    if(setting.time == undefined || setting.time == null)
        setting.time = 0;

    if(setting.color == undefined || setting.color == null)
        setting.color = "#ffd4a1";
    
    if(setting.effectElement == undefined || setting.effectElement == null)
        setting.effectElement = this;    

    $(setting.effectElement).animate({
        backgroundColor: setting.color,
        opacity: 0
    }, setting.time);
    
    $(this).fadeOut(setting.time, function(){ $(this).remove();});
};

$.fn.onErrorImage = function(func){
    if(func == undefined){
        $(this).on('error', function(){
            $(this).attr('src', URL.NO_IMAGE_AVAILABLE);
        });
    } else {
        func(this);
    }
};

/**
 * Add html at cursor position
 * @param {type} html
 * @returns {undefined}
 */
$.fn.pasteHtmlAtCaret = function(html) {
    this.focus();
    var parentEl = null, sel;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount) {
            parentEl = sel.getRangeAt(0).commonAncestorContainer;
            if (parentEl.nodeType != 1) {
                parentEl = parentEl.parentNode;
            }
        }
    } else if ( (sel = document.selection) && sel.type != "Control") {
        parentEl = sel.createRange().parentElement();
    }
    if($(parentEl).closest('#' + $(this).attr('id')).length === 0){
        return;
    }
    
    var sel, range;
    var selectPastedContent = true;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // only relatively recently standardized and is not supported in
            // some browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            var firstNode = frag.firstChild;
            range.insertNode(frag);
            
            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                if (selectPastedContent) {
                    //range.setStartBefore(firstNode);
                } else {
                    range.collapse(true);
                }
                sel.removeAllRanges();
                sel.addRange(range);
            }
            
        }
    } else if ( (sel = document.selection) && sel.type != "Control") {
        // IE < 9
        var originalRange = sel.createRange();
        originalRange.collapse(true);
        sel.createRange().pasteHTML(html);
        if (selectPastedContent) {
            range = sel.createRange();
            range.setEndPoint("StartToStart", originalRange);
            //range.select();
        }
    }
};

/**
 * Add html at cursor position
 * @param {type} html
 * @returns {undefined}
 */
$.fn.insertAtCaret = function(text){   
    var field = $(this).get(0);

    if (document.selection) {
        var range = document.selection.createRange();

        if (!range || range.parentElement() != field) {
            field.focus();
            range = field.createTextRange();
            range.collapse(false);
        }
        range.text = text;
        range.collapse(false);
        range.select();
    } else {
        field.focus();
        var val = field.value;
        var selStart = field.selectionStart;
        var caretPos = selStart + text.length;
        field.value = val.slice(0, selStart) + text + val.slice(field.selectionEnd);
        field.setSelectionRange(caretPos, caretPos);
    }
};

$.fn.focusEnd = function() {
    $(this).focus();
    var tmp = $('<span />').appendTo($(this)),
        node = tmp.get(0),
        range = null,
        sel = null;

    if (document.selection) {
        range = document.body.createTextRange();
        range.moveToElementText(node);
        range.select();
    } else if (window.getSelection) {
        range = document.createRange();
        range.selectNode(node);
        sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }
    tmp.remove();
    return this;
}

/**
 * Effect opacity waiting complete
 * @returns {undefined}
 */
$.fn.completing = function(){
    $(this).attr('data-old-opacity', $(this).css('opacity'));
    $(this).css({opacity: 0.5});
};

/**
 * Effect opacity completed
 * @returns {undefined}
 */
$.fn.completed = function(setting){
    if(setting == undefined || setting == null)
        setting = {};
    
    if(setting.time == undefined || setting.time == null)
        setting.time = 0;

    if(setting.backgroundColor == undefined || setting.backgroundColor == null)
        setting.backgroundColor = $(this).css('backgroundColor');
    
    if(setting.effectElement == undefined || setting.effectElement == null)
        setting.effectElement = this;    
    
    setting.oldBackgroundColor = $(this).css('backgroundColor');
    setting.oldBorderColor = $(this).css('borderColor');
    
    $(setting.effectElement).animate({
        backgroundColor: setting.backgroundColor,
        opacity: $(this).attr('data-old-opacity'),
    }, setting.time, function(){
        $(this).css({backgroundColor: setting.oldBackgroundColor});
    });
};

/**
 * Is After method, this method check the element js after
 * @param {type} sel
 * @returns {Boolean}
 */
$.fn.isAfter = function(sel) {
    return this.prev(sel).length !== 0;
};

/**
 * Is Before, This method check if element is before the other element
 * @param {type} sel
 * @returns {Boolean}
 */
$.fn.isBefore = function(sel) {
    return this.next(sel).length !== 0;
};

/**
 * Find after element
 * @param {type} sel
 * @returns {$.fn@call;next}
 */
$.fn.findAfter = function(sel) {
    return this.next(sel);
};

/**
 * Find before element
 * @param {type} sel
 * @returns {$.fn@call;prev}
 */
$.fn.findBefore = function(sel) {
    return this.prev(sel);
};

/**
 * Resize height by width with rate
 * @param {type} rate
 * @returns {undefined}
 */
$.fn.resizeHeight = function(rate, auto, afterEvent){
    if(rate == undefined){
        rate = 1;
    }
    
    if(auto == undefined){
        auto = false;
    }
    
    if(afterEvent == undefined){
        afterEvent = false;
    }
    
    var instance = this;
        
    function reset(){
        var height = $(instance).width()*rate;

        if(isNaN(height) || height < 0){
            //return;
        } else {
            $(instance).css('height',  height + 'px');
        }
        
        if(afterEvent != false){
            afterEvent(instance, $(instance).width(), height);
        }
    }
    
    reset();

    if(auto){ 
        $(window).resize(function(){
            reset();
        });
        
        $(window).on("orientationchange",function(){
            window.setTimeout(reset, 500);
        });
    }
};