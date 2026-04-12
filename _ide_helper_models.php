<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $content
 * @property string|null $featured_image
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int|null $author_id
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $author
 * @property-read int $reading_time
 * @property-read string $seo_description
 * @property-read string $seo_title
 * @property-read string $short_excerpt
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogPost whereUpdatedAt($value)
 */
	class BlogPost extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $buyer_id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $company_name
 * @property string|null $address_line
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $country
 * @property string|null $notes
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $creator
 * @property-read string $full_address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereAddressLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereZipCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withoutTrashed()
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $product_id
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address_line
 * @property string|null $city
 * @property string|null $zip_code
 * @property string|null $country
 * @property string|null $message
 * @property string|null $admin_reply
 * @property string $status
 * @property string|null $checkout_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereAddressLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereAdminReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereCheckoutToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Inquiry whereZipCode($value)
 */
	class Inquiry extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $invoice_number
 * @property int $order_id
 * @property int|null $generated_by
 * @property string $status
 * @property array<array-key, mixed>|null $client_snapshot
 * @property array<array-key, mixed>|null $financial_snapshot
 * @property \Illuminate\Support\Carbon|null $issued_at
 * @property \Illuminate\Support\Carbon|null $voided_at
 * @property int|null $voided_by
 * @property string|null $void_reason
 * @property string|null $pdf_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderAuditLog> $auditLogs
 * @property-read int|null $audit_logs_count
 * @property-read \App\Models\User|null $generatedBy
 * @property-read string $status_color
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\User|null $voidedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereClientSnapshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereFinancialSnapshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereGeneratedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereIssuedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice wherePdfPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereVoidReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereVoidedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereVoidedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice withoutTrashed()
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $order_number
 * @property string $type
 * @property string|null $checkout_token
 * @property int|null $client_id
 * @property int|null $created_by
 * @property string $status
 * @property string|null $payment_method
 * @property string|null $payment_reference
 * @property string|null $khalti_pidx
 * @property string|null $payment_details
 * @property numeric $subtotal
 * @property numeric $item_discount_total
 * @property string $order_discount_type
 * @property numeric $order_discount_value
 * @property numeric $order_discount_amount
 * @property numeric $shipping_cost
 * @property numeric $total_weight_kg
 * @property numeric $grand_total
 * @property bool $is_paid
 * @property \Illuminate\Support\Carbon|null $financial_locked_at
 * @property int|null $shipping_provider_id
 * @property string|null $tracking_number
 * @property \Illuminate\Support\Carbon|null $dispatched_at
 * @property \Illuminate\Support\Carbon|null $expected_delivery_at
 * @property int $delivery_period_days
 * @property array<array-key, mixed>|null $client_snapshot
 * @property int|null $merged_into_order_id
 * @property bool $is_merged
 * @property array<array-key, mixed>|null $merged_order_ids
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $cancelled_at
 * @property int|null $cancelled_by
 * @property string|null $cancellation_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderAuditLog> $auditLogs
 * @property-read int|null $audit_logs_count
 * @property-read \App\Models\User|null $cancelledBy
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\User|null $creator
 * @property-read mixed $address_line
 * @property-read mixed $city
 * @property-read mixed $country
 * @property-read mixed $email
 * @property-read mixed $name
 * @property-read mixed $phone
 * @property-read string $status_color
 * @property-read string $status_label
 * @property-read mixed $zip_code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Invoice> $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Invoice|null $latestInvoice
 * @property-read Order|null $mergedIntoOrder
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\ShippingProvider|null $shippingProvider
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order byStatus(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order inquiries()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order orders()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCancellationReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCancelledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCheckoutToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereClientSnapshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryPeriodDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDispatchedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereExpectedDeliveryAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereFinancialLockedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereIsMerged($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereItemDiscountTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereKhaltiPidx($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereMergedIntoOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereMergedOrderIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotalWeightKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $order_id
 * @property int|null $invoice_id
 * @property int|null $user_id
 * @property string $action_type
 * @property string|null $description
 * @property array<array-key, mixed>|null $old_values
 * @property array<array-key, mixed>|null $new_values
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read string $action_icon
 * @property-read string $action_label
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereNewValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereOldValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderAuditLog whereUserId($value)
 */
	class OrderAuditLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property int|null $product_id
 * @property array<array-key, mixed>|null $product_snapshot
 * @property int $quantity
 * @property numeric $unit_price
 * @property numeric $weight_kg
 * @property string $item_discount_type
 * @property numeric $item_discount_value
 * @property numeric $item_discount_amount
 * @property numeric $line_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $product_name
 * @property-read string $product_sku
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereItemDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereItemDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereItemDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereLineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereProductSnapshot($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItem whereWeightKg($value)
 */
	class OrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $order_id
 * @property string|null $notifiable_email
 * @property string $channel
 * @property string $event_type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property string|null $error_message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereErrorMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereNotifiableEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderNotification whereUpdatedAt($value)
 */
	class OrderNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property array<array-key, mixed>|null $config
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $category_id
 * @property int|null $sub_category_id
 * @property string|null $description
 * @property int $stock
 * @property string|null $long_description
 * @property int $min_quantity
 * @property string|null $material
 * @property numeric $price
 * @property numeric|null $discount_price
 * @property string|null $sku
 * @property numeric|null $length
 * @property numeric|null $width
 * @property numeric|null $height
 * @property numeric|null $weight
 * @property string|null $main_image
 * @property string|null $secondary_image
 * @property array<array-key, mixed>|null $images
 * @property bool $is_order_now_enabled
 * @property bool $is_new_arrival
 * @property bool $is_featured
 * @property bool $is_recommended
 * @property bool $is_on_sale
 * @property int $carousel_priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read mixed $effective_price
 * @property-read mixed $formatted_height
 * @property-read mixed $formatted_length
 * @property-read mixed $formatted_weight
 * @property-read mixed $formatted_width
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Inquiry> $inquiries
 * @property-read int|null $inquiries_count
 * @property-read \App\Models\SubCategory|null $subCategory
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newArrivals()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onSale()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product recommended()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCarouselPriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsNewArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsOrderNowEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsRecommended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMainImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMinQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSecondaryImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereWidth($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShippingRate> $rates
 * @property-read int|null $rates_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingProvider whereUpdatedAt($value)
 */
	class ShippingProvider extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $shipping_provider_id
 * @property int $shipping_zone_id
 * @property numeric $min_weight
 * @property numeric $max_weight
 * @property numeric $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ShippingProvider $provider
 * @property-read \App\Models\ShippingZone $zone
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate whereMaxWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate whereMinWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate whereShippingProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate whereShippingZoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingRate whereUpdatedAt($value)
 */
	class ShippingRate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property array<array-key, mixed>|null $countries
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShippingRate> $rates
 * @property-read int|null $rates_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone whereCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShippingZone whereUpdatedAt($value)
 */
	class ShippingZone extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $type
 * @property string|null $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiteSetting whereValue($value)
 */
	class SiteSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereUpdatedAt($value)
 */
	class SubCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property string|null $last_login_ip
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User admins()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User inactive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

