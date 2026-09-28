import { useCartStore, type CartItem } from '@/stores/cartStore';
import { storeToRefs } from 'pinia';

export function useCart() {
    const cartStore = useCartStore();
    const { items, totalItems, totalPrice } = storeToRefs(cartStore);

    const addItem = (item: CartItem) => {
        cartStore.addItem(item);
    };

    const removeItem = (itemId: number) => {
        cartStore.removeItem(itemId);
    };

    const updateItemQuantity = (itemId: number, quantity: number | string) => {
        cartStore.updateItemQuantity(itemId, quantity);
    };

    const clearCart = () => {
        cartStore.clearCart();
    };

    return {
        items,
        totalItems,
        totalPrice,
        addItem,
        removeItem,
        updateItemQuantity,
        clearCart,
    };
}
