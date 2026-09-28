import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

export interface CartItem {
    id: number;
    name: string;
    price: number;
    quantity: number;
    image: string;
    event_id: number;
}

export const useCartStore = defineStore('cart', () => {
    const items = ref<CartItem[]>([]);

    const totalItems = computed(() => {
        return items.value.reduce((acc, item) => acc + item.quantity, 0);
    });

    const totalPrice = computed(() => {
        return Number(items.value.reduce((acc, item) => acc + item.price * item.quantity, 0).toFixed(2));
    });

    const addItem = (item: CartItem) => {
        const existingItem = items.value.find((i) => i.id === item.id && i.event_id === item.event_id);
        if (existingItem) {
            existingItem.quantity += item.quantity;
        } else {
            items.value.push({ ...item });
        }
    };

    const removeItem = (itemId: number) => {
        items.value = items.value.filter((item) => item.id !== itemId);
    };

    const updateItemQuantity = (itemId: number, quantity: number | string) => {
        const parsed = typeof quantity === 'string' ? Number.parseInt(quantity, 10) : quantity;

        if (Number.isNaN(parsed) || parsed <= 0) {
            removeItem(itemId);
            return;
        }
        const item = items.value.find((i) => i.id === itemId);
        if (item) {
            item.quantity = parsed;
        }
    };

    const clearCart = () => {
        items.value = [];
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
});
