/* Vanilla JS version of jquery-ajax requesting
    Did not want to use jquery as in lecture 319
    Source:

    https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/responseURL
     */

document.addEventListener( "DOMContentLoaded", function () {
    var like = document.querySelector( ".like" );
    var post_id = <? php echo $post_page_id; ?>;
    var user_id = <? php echo $_SESSION['user_id']; ?>;;
    var request = new XMLHttpRequest();

    like.addEventListener( "click", function () {

        request.open( 'POST', `/cms/post.php?p_id=${post_id}`, true );
        // setRequestHeader is essential otherwise $_POST won't pick it up
        request.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
        request.onload = function () {
            console.log( `Liked post ID -> ${post_id}` );
        };
        request.send( `post_id=${post_id}&liked=1&user_id=${user_id}` );
    } );
} );