<div id="main-container" class="container">
    <div class="row">

        <?=$this->template("coreshop/helper/left.php")?>

        <div class="col-md-9">

            <ol class="breadcrumb">
                <li><a href="<?=\CoreShop::getTools()->url(array("lang" => $this->language), "coreshop_index", true)?>"><?=$this->translate("Home")?></a></li>
                <?php if(count($this->product->getCategories()) > 0) { ?>
                    <?php foreach($this->product->getCategories()[0]->getHierarchy() as $cat) { ?>
                        <li><a href="<?=$cat->getCategoryUrl($this->language);?>"><?=$cat->getName()?></a></li>
                    <?php } ?>
                <?php } ?>
                <li class="active"><a href="<?=$this->product->getProductUrl($this->language);?>"><?=$this->product->getName()?></a></li>
            </ol>


            <div class="row product-info">

                <div class="col-sm-5 images-block">
                    <?php if($this->product->getImage() instanceof \Pimcore\Model\Asset\Image) { ?>
                        <?php if($this->product->getIsNew()) { ?>
                            <div class="image-new-badge"></div>
                        <?php } ?>

                        <img src="<?=$this->product->getImage()->getThumbnail("coreshop_productDetail")?>?>" alt="<?=$this->product->getName()?>" id="product-image-<?=$this->product->getId()?>" class="img-responsive thumbnail" />
                    <?php } ?>
                    <?php if(count($this->product->getImages()) > 0) { ?>
                        <ul class="list-unstyled list-inline">
                            <?php foreach($this->product->getImages() as $image) { ?>
                                <li>
                                    <?php
                                    echo $image->getThumbnail("coreshop_productDetailThumbnail")->getHtml(array("class" => "img-responsive thumbnail", "alt" => $this->product->getName()));
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>

                <div class="col-sm-7 product-details">

                    <h2><?=$this->product->getName()?></h2>
                    <hr />

                    <?php if(strlen($this->product->getShortDescription()) > 0) { ?>
                        <div class="description">
                            <?=$this->product->getShortDescription()?>
                        </div>
                        <hr />
                    <?php } ?>

                    <ul class="list-unstyled manufacturer">
                        <?php if($this->product->getManufacturer() instanceof \CoreShop\Model\Manufacturer) { ?>
                        <li>
                            <span><?=$this->translate("Brand")?>:</span> <?=$this->product->getManufacturer()->getName()?>
                        </li>
                        <?php }?>
                        <?php if($this->product->getEan()) { ?>
                            <li><span><?=$this->translate("Model")?>:</span> <?=$this->product->getEan()?></li>
                        <?php }?>
                        <li>
                            <span>Availability:</span>
                            <?php if($this->product->getQuantity() > 0) { ?>
                                <strong class="label label-success"> <?=$this->translate("In Stock")?></strong>
                            <?php } else if($this->product->isAvailableWhenOutOfStock()) { ?>
                                <div class="label label-warning">
                                    <?=$this->translate("Out of Stock, but already on back order.")?>
                                </div>
                            <?php } else { ?>
                                <div class="label label-danger">
                                    <?=$this->translate("Out of Stock")?>
                                </div>
                            <?php } ?>
                        </li>
                    </ul>
                    <hr/>

                    <?php
                        $variants = $this->product->getVariantDifferences( $this->language, 'classificationstore', 'classificationStore' ); //Use this for classification store
                        //$variants = $this->product->getVariantDifferences( $this->language ); //Use this for bricks
                    ?>

                    <?php if(!empty($variants)) {
                        foreach($variants as $variant) {  ?>
                            <h4><?=$variant['variantName']?></h4>
                            <div class="form-group">
                                <select name="variant" class="form-control selectpicker btn-white">

                                    <?php foreach($variant['variantValues'] as $variantValue) { ?>
                                        <?php

                                            $variantProduct = \CoreShop\Model\Product::getById($variantValue['productId']);

                                            $href = $variantProduct->getProductUrl($this->language);
                                        ?>
                                        <option data-href="<?=$href?>" value="<?=$variantValue['productId']?>" <?=$variantValue['selected'] ? "selected" : ""?>><?=$this->translate($variantValue['variantName'])?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <hr/>
                    <?php } ?>

                    <?php if($this->product->getAvailableForOrder()) { ?>
                        <div class="price">
                            <span class="price-head"><?=$this->translate("Price")?> :</span>
                            <span class="price-new"><?=\CoreShop::getTools()->formatPrice($this->product->getPrice(\CoreShop::getTools()->displayPricesWithTax()));?></span>
                            <?=$this->template("product/helper/product-savings.php");?>
                        </div>
                        <div class="tax">
                            <?php if(\CoreShop::getTools()->displayPricesWithTax()) { ?>
                                <?=sprintf($this->translate("incl. %s%% Tax"), $this->product->getTaxRate())?> (<?=\CoreShop::getTools()->formatPrice($this->product->getTaxAmount())?>)
                            <?php } else { ?>
                                <?=$this->translate("ex. VAT");?>
                            <?php } ?>

                        </div>

                        <div class="shipping">
                            <?php if($this->product->getCheapestDeliveryPrice() > 0) { ?>
                                <?=sprintf($this->translate("Shipping from %s"), \CoreShop::getTools()->formatPrice($this->product->getCheapestDeliveryPrice()))?>
                            <?php } else { ?>
                                <?=$this->translate("Free Shipping")?>
                            <?php } ?>
                        </div>
                        <hr/>

                        <?php /*
                        <?php if(count($this->product->getValidSpecificPriceRules()) > 0) { ?>
                            <div class="price-rules">
                                <ul>
                                    <?php foreach($this->product->getValidSpecificPriceRules() as $rule) { ?>
                                        <?php foreach($rule->getActions() as $action) { ?>
                                            <li>
                                                <?php
                                                    if($action instanceof \CoreShop\Model\PriceRule\Action\DiscountAmount) {
                                                        echo $this->translate(sprintf("You will get a discount of %s.", \CoreShop::getTools()->formatPrice($action->getAmount())));
                                                    }
                                                    else if($action instanceof \CoreShop\Model\PriceRule\Action\DiscountPercent) {
                                                        echo $this->translate(sprintf("You will get a discount of %s%%.", $action->getPercent()));
                                                    }
                                                    else if($action instanceof \CoreShop\Model\PriceRule\Action\NewPrice) {
                                                        echo $this->translate(sprintf("You will get a total new price of %s instead of %s.", \CoreShop::getTools()->formatPrice($action->getNewPrice()), \CoreShop::getTools()->formatPrice($this->product->getRetailPriceWithTax())));
                                                    }
                                                ?>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                            <hr/>
                        <?php } ?>
                        */ ?>
                        
                        <div class="options">
                            <?php if(!\CoreShop\Model\Configuration::isCatalogMode() && ($this->product->isAvailableWhenOutOfStock() || $this->product->getQuantity() > 0)) { ?>
                                <div class="form-group">
                                    <label class="control-label text-uppercase" for="input-quantity"><?=$this->translate("Qty")?>:</label>
                                    <input type="text" name="quantity" value="1" size="2" id="input-quantity" class="form-control" />
                                </div>
                            <?php } ?>

                            <div class="cart-button button-group">
                                <button type="button" title="Wishlist" class="btn btn-wishlist" data-id="<?=$this->product->getId()?>">
                                    <i class="fa fa-heart"></i>
                                </button>
                                <button type="button" title="Compare" class="btn btn-compare" data-id="<?=$this->product->getId()?>">
                                    <i class="fa fa-bar-chart-o"></i>
                                </button>

                                <?php if(!\CoreShop\Model\Configuration::isCatalogMode() && ($this->product->isAvailableWhenOutOfStock() || $this->product->getQuantity() > 0)) { ?>
                                    <button type="button" class="btn btn-cart" data-id="<?=$this->product->getId()?>" data-img="#product-image-<?=$this->product->getId()?>" data-amount="input-quantity">
                                        <?=$this->translate("Add to cart")?>
                                        <i class="fa fa-shopping-cart"></i>
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <hr />
                </div>
            </div>

            <div class="tabs-panel panel-smart">
                <!-- Nav Tabs Starts -->
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-description"><?=$this->translate("Description")?></a>
                    </li>
                    <?php if(count($this->similarProducts) > 0) { ?>
                    <li>
                        <a href="#tab-similar"><?=$this->translate("Similar Products")?></a>
                    </li>
                    <?php }?>
                    <li>
                        <a href="#tab-contact"><?=$this->translate("Contact")?></a>
                    </li>
                </ul>

                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="tab-description">
                        <?php
                            echo strlen($this->product->getDescription()) > 0 ? $this->product->getDescription() : $this->translate("Sorry, but there is no description available");
                        ?>
                    </div>

                    <?php if(count($this->similarProducts) > 0) { ?>
                    <div class="tab-pane" id="tab-similar">
                        <div class="row">
                        <?php
                            foreach($this->similarProducts as $product) {
                                echo $this->template("product/helper/product-list.php", array("product" => $product));
                            }
                        ?>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="tab-pane" id="tab-contact">
                        <?php if($this->success === false) { ?>
                            <div class="alert alert-danger"><?=$this->error?></div>
                        <?php } ?>

                        <?php if($this->success === true) { ?>
                            <div class="alert alert-success"><?=$this->translate("Your message has been sent to our team.")?></div>
                        <?php } ?>

                        <?php if($this->success === false || is_null($this->success)) { ?>
                            <?php
                            $postValue = function ($name) {
                                if (isset($this->params[$name])) {
                                    return $this->params[$name];
                                }

                                return null;
                            };
                            ?>

                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post">
                                    <div class="form-group">
                                        <label for="contact" class="col-sm-2 control-label">
                                            <?=$this->translate("Subject")?>
                                        </label>
                                        <div class="col-sm-10">
                                            <select name="contact" class="form-control" id="contact">
                                                <?php foreach($this->contacts as $contact) { ?>
                                                    <option value="<?=$contact->getId()?>" <?=$postValue("contact") === $contact->getId() ? 'selected="selected"' : "" ?> ><?=$contact->getName()?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">
                                            <?=$this->translate("Email")?>
                                        </label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="<?=$this->translate("Email")?>" value="<?=$postValue('email')?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-sm-2 control-label">
                                            <?=$this->translate("Message")?>
                                        </label>
                                        <div class="col-sm-10">
                                            <textarea name="message" id="message" class="form-control" rows="5" placeholder="<?=$this->translate("Message")?>"><?=$postValue("message")?></textarea>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="button-review" class="btn btn-main">
                                                <?=$this->translate("Submit")?>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>