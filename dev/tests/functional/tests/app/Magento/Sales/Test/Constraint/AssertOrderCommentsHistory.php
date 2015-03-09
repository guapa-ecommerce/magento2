<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Sales\Test\Constraint;

use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert  that comment about authorized amount exist in Comments History section on order page in backend
 */
class AssertOrderCommentsHistory extends AbstractConstraint
{
    /**
     * Assert  that comment about authorized amount exist in Comments History section on order page in backend.
     *
     * @param SalesOrderView $salesOrderView
     * @param OrderIndex $salesOrder
     * @param string $orderId
     * @param string $grandTotal
     * @return void
     */
    public function processAssert(
        SalesOrderView $salesOrderView,
        OrderIndex $salesOrder,
        $orderId,
        $grandTotal
    ) {
        $salesOrder->open();
        $salesOrder->getSalesOrderGrid()->searchAndOpen(['id' => $orderId]);

        $actualAuthorizedAmount = $salesOrderView->getOrderHistoryBlock()->getCommentsHistory();
        $expectedAuthorizedAmount = 'Authorized amount of $' . $grandTotal;

        \PHPUnit_Framework_Assert::assertContains(
            $expectedAuthorizedAmount, $actualAuthorizedAmount,
            'Incorrect authorized amount value for the order #' . $orderId
        );
    }

    /**
     * Returns string representation of successful assertion.
     *
     * @return string
     */
    public function toString()
    {
        return "Message about authorized amount is available in Comments History section.";
    }
}
