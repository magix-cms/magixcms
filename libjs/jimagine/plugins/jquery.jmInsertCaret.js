/**
 * Example
 * <a href="#" class="keyword" data-keyword="[[EXAMPLE]]">
     [[EXAMPLE]]
   </a>
 */
;(function ( $, window, document, undefined ) {
    $.fn.jmInsertCaret = function(settings) {
        var options =  {
            textAreaId: ""
        };

        if ($.isPlainObject(settings)) {
            var o = $.extend(true, options, settings || {});
        }else{
            console.log("%s: %o","insertCaret settings is not object");
        }

        /**
         * Add cursor text position
         * @param textArea
         * @param cursorPosition
         * @param text
         */
        function addTextAtCursorPosition(textArea, cursorPosition, text) {
            var front = (textArea.value).substring(0, cursorPosition);
            var back = (textArea.value).substring(cursorPosition, textArea.value.length);
            textArea.value = front + text + back;
        }

        /**
         * Update Cursor Position
         * @param cursor
         * @param text
         * @param textArea
         */
        function updateCursorPosition(cursor, text, textArea) {
            var cursorPosition = cursor + text.length;
            textArea.selectionStart = cursorPosition;
            textArea.selectionEnd = cursorPosition;
            textArea.focus();
        }

        /**
         * Ini insert text
         * @param keyword
         */
        function addTextAtCaret(keyword) {
            var textArea = document.getElementById(options.textAreaId);
            var cursorPosition = textArea.selectionStart;
            addTextAtCursorPosition(textArea, cursorPosition, keyword);
            updateCursorPosition(cursorPosition, keyword, textArea);
        }

        if(options.textAreaId.length != '0'){
            return this.each(function(i, item){
                $(item).off();
                $(item).on('click',function(e){
                    e.preventDefault();
                    var selfelem = $(this);
                    var keyword = selfelem.data('keyword');
                    if(keyword.length != '0'){
                        addTextAtCaret(keyword);
                    }
                });
            });
        }else{
            console.log("%s: %o","textAreaId is NULL");
        }
    };
})( jQuery, window, document );