<!--<div class="modal fade" id="myModal" role="dialog">-->
<!--    <div class="modal-dialog">-->
    
      <!-- Modal content-->
<!--      <div class="modal-content">-->
<!--        <div class="modal-header">-->
<!--          <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--          <h4 class="modal-title">Modal Header</h4>-->
<!--        </div>-->
<!--        <div class="modal-body">-->
<!--          <p>Some text in the modal.</p>-->
<!--        </div>-->
<!--        <div class="modal-footer">-->
<!--          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--        </div>-->
<!--      </div>-->
      
<!--    </div>-->
<!--  </div>-->
  <div class="modal fade" id="buynow_modal" tabindex="-1" aria-labelledby="buynow_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content py-20">
            <div class="d-flex align-items-center justify-content-between px-20">
                <h3 class="section-title after-line"></h3>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x" width="25" height="25"></i>
                </button>
            </div>

            <div class="mt-25 position-relative">
                

                

                <div class="modal-video-lists mt-15">

                  
                                    <div class="d-flex justify-content-between align-items-center my-15 px-20">
                                        <h3 class="section-title after-line">Please login to access the content.</h3>
                                    </div>

                                        <div class="rounded-lg shadow-sm  col-12 col-lg-4 mt-25 mt-lg-0" style="margin-right: auto;margin-left: auto;">
                                            
                                            <div class="px-20 pb-30">
                        <form action="/cart/store" method="post">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="item_id" value="<?php echo e($course->id); ?>">
                            <input type="hidden" name="item_name" value="webinar_id">

                            <?php if(!empty($course->tickets)): ?>
                                <?php $__currentLoopData = $course->tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="form-check mt-20">
                                        <input class="form-check-input" <?php if(!$ticket->isValid()): ?> disabled <?php endif; ?> type="radio" data-discount="<?php echo e($ticket->discount); ?>" value="<?php echo e(($ticket->isValid()) ? $ticket->id : ''); ?>"
                                               name="ticket_id"
                                               id="courseOff<?php echo e($ticket->id); ?>">
                                        <label class="form-check-label d-flex flex-column cursor-pointer" for="courseOff<?php echo e($ticket->id); ?>">
                                            <span class="font-16 font-weight-500 text-dark-blue"><?php echo e($ticket->title); ?> <?php if(!empty($ticket->discount)): ?>
                                                    (<?php echo e($ticket->discount); ?>% <?php echo e(trans('public.off')); ?>)
                                                <?php endif; ?></span>
                                            <span class="font-14 text-gray"><?php echo e($ticket->getSubTitle()); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <?php if($course->price > 0): ?>
                                <div id="priceBox" class="d-flex align-items-center justify-content-center mt-20 <?php echo e(!empty($activeSpecialOffer) ? ' flex-column ' : ''); ?>">
                                    <div class="text-center">
                                        <?php
                                            $realPrice = handleCoursePagePrice($course->price);
                                        ?>
                                        <span id="realPrice" data-value="<?php echo e($course->price); ?>"
                                              data-special-offer="<?php echo e(!empty($activeSpecialOffer) ? $activeSpecialOffer->percent : ''); ?>"
                                              class="d-block <?php if(!empty($activeSpecialOffer)): ?> font-16 text-gray text-decoration-line-through <?php else: ?> font-30 text-primary <?php endif; ?>">
                                            <?php echo e($realPrice['price']); ?>

                                        </span>

                                        <?php if(!empty($realPrice['tax']) and empty($activeSpecialOffer)): ?>
                                            <span class="d-block font-14 text-gray">+ <?php echo e($realPrice['tax']); ?> <?php echo e(trans('cart.tax')); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if(!empty($activeSpecialOffer)): ?>
                                        <div class="text-center">
                                            <?php
                                                $priceWithDiscount = handleCoursePagePrice($course->getPrice());
                                            ?>
                                            <span id="priceWithDiscount"
                                                  class="d-block font-30 text-primary">
                                                <?php echo e($priceWithDiscount['price']); ?>

                                            </span>

                                            <?php if(!empty($priceWithDiscount['tax'])): ?>
                                                <span class="d-block font-14 text-gray">+ <?php echo e($priceWithDiscount['tax']); ?> <?php echo e(trans('cart.tax')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center mt-20">
                                    <span class="font-36 text-primary"><?php echo e(trans('public.free')); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php
                                $canSale = ($course->canSale() and !$hasBought);
                            ?>

                            <div class="mt-20 d-flex flex-column">
                                <?php if(!$canSale and $course->canJoinToWaitlist()): ?>
                                    <button type="button" data-slug="<?php echo e($course->slug); ?>" class="btn btn-primary <?php echo e((!empty($authUser)) ? 'js-join-waitlist-user' : 'js-join-waitlist-guest'); ?>"><?php echo e(trans('update.join_waitlist')); ?></button>
                                <?php elseif($hasBought or !empty($course->getInstallmentOrder())): ?>
                                    <a href="<?php echo e($course->getLearningPageUrl()); ?>" class="btn btn-primary"><?php echo e(trans('update.go_to_learning_page')); ?></a>
                                <?php elseif($course->price > 0): ?>
                                    <button type="button" class="btn btn-primary <?php echo e($canSale ? 'js-course-add-to-cart-btn' : ($course->cantSaleStatus($hasBought) .' disabled ')); ?>">
                                        <?php if(!$canSale): ?>
                                            <?php echo e(trans('update.disabled_add_to_cart')); ?>

                                        <?php else: ?>
                                            <?php echo e(trans('public.add_to_cart')); ?>

                                        <?php endif; ?>
                                    </button>

                                    <?php if($canSale and $course->subscribe): ?>
                                        <a href="/subscribes/apply/<?php echo e($course->slug); ?>" class="btn btn-outline-primary btn-subscribe mt-20 <?php if(!$canSale): ?> disabled <?php endif; ?>"><?php echo e(trans('public.subscribe')); ?></a>
                                    <?php endif; ?>

                                    <?php if($canSale and !empty($course->points)): ?>
                                        <a href="<?php echo e(!(auth()->check()) ? '/login' : '#'); ?>" class="<?php echo e((auth()->check()) ? 'js-buy-with-point' : ''); ?> btn btn-outline-warning mt-20 <?php echo e((!$canSale) ? 'disabled' : ''); ?>" rel="nofollow">
                                            <?php echo trans('update.buy_with_n_points',['points' => $course->points]); ?>

                                        </a>
                                    <?php endif; ?>

                                    <?php if($canSale and !empty(getFeaturesSettings('direct_classes_payment_button_status'))): ?>
                                        <button type="button" class="btn btn-outline-danger buy_now mt-20 js-course-direct-payment">
                                            <?php echo e(trans('update.buy_now')); ?>

                                        </button>
                                    <?php endif; ?>

                                    <?php if(!empty($installments) and count($installments) and getInstallmentsSettings('display_installment_button')): ?>
                                        <a href="/course/<?php echo e($course->slug); ?>/installments" class="btn btn-outline-primary mt-20">
                                            <?php echo e(trans('update.pay_with_installments')); ?>

                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo e($canSale ? '/course/'. $course->slug .'/free' : '#'); ?>" class="btn btn-primary <?php echo e((!$canSale) ? (' disabled ' . $course->cantSaleStatus($hasBought)) : ''); ?>"><?php echo e(trans('public.enroll_on_webinar')); ?></a>
                                <?php endif; ?>
                            </div>

                        </form>

                       

                        
                    

                    
                </div>
                          
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/examsexplorer/public_html/resources/views/web/default/course/buynow_modal.blade.php ENDPATH**/ ?>