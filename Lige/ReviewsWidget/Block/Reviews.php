<?php

/**
 * Class Lige_ReviewsWidget_Block_Reviews
 */
class Lige_ReviewsWidget_Block_Reviews extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
    /**
     * Generates HTML with ALL reviews
     *
     * @return string
     */
    protected function _toHtml()
    {
        $reviews = Mage::getModel('review/review')->getResourceCollection();
        $reviews->addStoreFilter( Mage::app()->getStore()->getId() )
            ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
            ->setDateOrder()
            ->addRateVotes()
            ->load();

        $html  = '<div id="reviews-container" class="reviews-container">' ;
        foreach($reviews->getItems() as $review){
            $html .= '<div class="col-md-3 col-sm-6 col-sx-12 single-review">';
            $html .= '<div class="review-text">' .$review->getDetail(). "</div>";
            $html .= '<div class="review-nickname">' .$review->getNickname(). "</div>";
            $html .= '<div class="review-rating">';

            if (count($review->getRatingVotes()) > 0) {
                $ratings = $review->getRatingVotes();

                foreach ($ratings as $rating) {
                    $html .= '<div class="rating" style="width: '.$rating->getPercent().'%"></div>';
                }
            }

            $html .= "</div>";
            $html .= "</div>";
        }
        $html .= "</div>";
        return $html;
    }
};