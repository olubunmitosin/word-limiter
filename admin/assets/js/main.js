(function ($) {
    "use strict";
    /**
     * Word Limiter.
     * Author: victor
     * Date: 10/13/18
     * Time: 4:22 PM
     */

    var $enter_less,
        $number_of_words,
        $default_message,
        $returned_message;

    /**
     * Handle action buttons of snax editor for
     * frontend submissions.
     * @param condition
     * @param holder
     * @param feedbackM
     * @param remaining
     * @param no_of_words
     */
    function handleActionButtons( condition, holder, feedbackM, remaining, no_of_words ) {
        if ( condition === false ) {
            if ( remaining < 1 ) {
                holder.html(' ' + feedbackM + ' ' + no_of_words + ' words');
            } else {
                holder.html( 'You have ' + remaining + ' words remaining' );
            }
            $('.snax-draft-post-row-actions').css('display', 'none');
            $('.snax-edit-post-row-actions').css('display', 'none');
        } else {
            $('.snax-draft-post-row-actions').css('display', '');
            $('.snax-edit-post-row-actions').css('display', '');
            holder.html('You have ' + remaining + ' words remaining');
        }
    }

    $(document).ready(function(){
        $("body").on("contextmenu",function(e){
            return false;
        });
        //Disable cut copy paste
        $('body').on('paste', function (e) {
            e.preventDefault();
        });

        $('.snax-draft-post-row-actions').css('display','none');
        $('.snax-edit-post-row-actions').css('display','none');

        // This is what we are sending the server
        var data = {
            action: 'word_limiter_ajax_get_data',
            nonce: word_limiter_params.nonce
        };

        $.ajax({
            url: word_limiter_params.ajaxurl,
            type: 'POST',
            data: data,
            success: function (data) {
                //check if action is successful
                if ( data.status === true ) {
                    //Get parameters
                    $enter_less = data.enter_less;
                    $number_of_words = data.number_of_words;
                    $default_message = data.default_message;
                    $returned_message = data.returned_message;


                    /**
                     * Now we handle frontend submission forms below.
                     * First, we need to get the snax editor anchor and
                     * there after we set in our plugin options to the editor
                     */
                    // //var $snax_form = $(document).find('.entry-content .snax .snax-form-frontend');
                    // var $wrapper = $('.snax-form-main .snax-edit-post-row-content .fr-box .fr-toolbar');

                    $('.snax-form-main .snax-edit-post-row-title').after(
                        '<div id="word-limiter-container"><p style="padding-top: 5px;"> <span id="word_limiter_message_1">' + $default_message + ' is ' + $number_of_words + '</span> <span style="color: #fea620;">| Do not paste into Editor.</span></p></div>');
                    //initialize watcher
                    $('.snax-form-main .snax-edit-post-row-content .fr-box .fr-wrapper .fr-element p').watch({
                        properties: "prop_innerHTML",
                        watchChildren: true,
                        callback: function (data, i) {
                            var holder = $('#word_limiter_message_1');
                            holder.html('');
                            //collect text
                            var $inputText = data.vals[i];
                            var words = $.trim($inputText).split(" ").length;
                            var wordsChars = $.trim($inputText).length;
                            var wordsRemaining = parseInt($number_of_words) - parseInt(words);
                            //Get the anchor for Snax Text Box
                            var $textArea = $('#snax-post-description');
                            holder.html( 'You have ' + wordsRemaining + ' words remaining' );

                            /**
                             * From here, we'll need to validate user input against admin
                             * settings. We must ensure user submits words that is in accordance
                             * with maximum number of words allowed by the administrator.
                             */
                            if ( $enter_less === 'yes' && wordsRemaining === 0) {
                                /**
                                 * Users are allowed to enter words less than number allowed
                                 * and must be exactly the number of words allowed by the admin.
                                 * but at this point, condition is met.
                                 */
                                //set textArea maximum character length
                                $textArea.attr('maxlength', wordsChars);
                                //handle action buttons
                                handleActionButtons( true, holder, $returned_message, wordsRemaining, $number_of_words );
                            }

                            /**
                             * We don't have business with when it is less than
                             * cause admin has already set that.
                             */
                            if ( $enter_less === 'yes' && words > $number_of_words) {
                                /**
                                 * Users are not allowed to enter words greater than number of
                                 * words allowed, but can enter words less that stipulated words.
                                 * Must be exactly the number of words allowed by the admin.
                                 * but here we'll restrict user from submitting any story since
                                 * words are greater than stipulated words.
                                 */
                                //set textArea maximum character length
                                $textArea.attr('maxlength', wordsChars);
                                //handle buttons
                                handleActionButtons( false, holder, $returned_message, wordsRemaining, $number_of_words );
                            }
                            /**
                             * Admin wants the number to be exactly the number of words
                             * he set into the settings, now we have a business to handle.
                             */
                            if ( $enter_less === 'no' && words < $number_of_words ) {
                                /**
                                 * Users are not allowed to enter words less than number allowed
                                 * and must be exactly the number of words allowed by the admin.
                                 * but here we'll restrict user from submitting any story since
                                 * words are less than stipulated words.
                                 */
                                //set textArea maximum character length
                                $textArea.attr('maxlength', wordsChars);

                                holder.html('You have ' + $number_of_words + ' words remaining');

                                //handle action buttons
                                handleActionButtons( false, holder, $returned_message, wordsRemaining, $number_of_words );
                            }

                            if ( $enter_less === 'no' && words > $number_of_words ) {
                                /**
                                 * Users are not allowed to enter words greater than number of words allowed
                                 * and must be exactly the number of words allowed by the admin.
                                 * but here we'll restrict user from submitting any story since
                                 * words are greater than stipulated words.
                                 */
                                //set textArea maximum character length
                                $textArea.attr('maxlength', wordsChars);
                                //handle action buttons
                                handleActionButtons( false, holder, $returned_message, wordsRemaining, $number_of_words );
                            }

                            if ( $enter_less === 'no' && wordsRemaining === 0) {
                                /**
                                 * Users are allowed to enter words less than number allowed
                                 * and must be exactly the number of words allowed by the admin.
                                 * but at this point, condition is met.
                                 */
                                //set textArea maximum character length
                                $textArea.attr('maxlength', wordsChars);
                                //handle action buttons
                                handleActionButtons( true, holder, $returned_message, wordsRemaining, $number_of_words );

                            }

                        }
                    });

                }
                //if status returns true ends here
            }
            //success function ends here
        });
    });

})(jQuery);
