import { Event } from '@/types/models/Event';
import { EventRoomSlot } from '@/types/models/EventRoomSlot';

export interface EventRoom {
    id: string;
    name: string;
    location: string | null;
    notes: string | null;
    available: boolean;
    created_at: Date | null;
    updated_at: Date | null;
    event_id: string;
    event: Event | null;
    slots: EventRoomSlot[];
}
