<?php
namespace KaziBundle\Helper;

// Correct use statements here ...

class NewsHelper {

    /*private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }*/

    public function getYoutubeUrlEmbed($youtube_url) {
        if($youtube_url != '') {
            $url = urldecode(rawurldecode( $youtube_url ));
            # https://www.youtube.com/watch?v=nn5hCEMyE-E

            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
            // echo $matches[1];
            // exit();
            $youtubeUrlEmbed = 'https://www.youtube.com/embed/' . $matches[1];
        }  

        return $youtubeUrlEmbed;
    }
}