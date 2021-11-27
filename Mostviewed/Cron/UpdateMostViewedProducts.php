<?php
/**
 * Copyright © Shawatech All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Shawatech\Mostviewed\Cron;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class UpdateMostViewedProducts
{
    protected $collectionFactory;
    protected $mostViewedCollectionFactory;
    protected $action;
    protected $logger;
    /**
     * Constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $mostViewedCollectionFactory
     * @param \Magento\Catalog\Model\Product\Action $action
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $mostViewedCollectionFactory,
        \Magento\Catalog\Model\Product\Action $action,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->action = $action;
        $this->mostViewedCollectionFactory = $mostViewedCollectionFactory;
        $this->logger = $logger;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $_test=[];
        $mostViewedCollection=
        $this->mostViewedCollectionFactory->create()
        ->addStoreFilter(1)
        ->addViewsCount();
        $collection=$this->collectionFactory->create()
        ->addAttributeToFilter('most_viewed',['gteq'=>0])
        ->addAttributeToSelect(['most_viewed']);
        $existngMostViewedProducts=$this->_toArray($collection);
        try{
            if(!empty($mostViewedCollection) && $mostViewedCollection->getSize()){
                foreach($mostViewedCollection as $product){
                    if(!isset($existngMostViewedProducts[$product->getId()]) || 
                        (isset($existngMostViewedProducts[$product->getId()]) &&
                            $existngMostViewedProducts[$product->getId()] !=$product->getViews()
                        )
                        ){
                            $_test[$product->getId()]=$product->getViews();
                            $this->action->updateAttributes(
                                [$product->getId()],
                                ['most_viewed' => $product->getViews()],
                                0
                            );  
                    }

                }
            }
        }catch(\Exception $e){
        }
        $this->logger->addInfo("Cronjob UpdateMostViewedProducts is executed.");
    }
    /**
     * _toArray function
     *
     * @param object $items
     * @return void
     */
    private function _toArray($items){
        $toArray=[];
        if(empty($items)){
            return [];
        }
        foreach($items as $item)
        {
            $toArray[$item->getId()]=$item->getMostViewed(); 
        }
        return $toArray;
    }
}

