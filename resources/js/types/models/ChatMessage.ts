import { Attendee } from '@/types/models/Attendee';

export interface ChatMessage {
    id: string;
    message: string;
    is_room_slot_invite: number;
    created_at: Date | null;
    updated_at: Date | null;
    sender_attendee_id: string;
    receiver_attendee_id: string;
    sender_attendee: Attendee | null;
    receiver_attendee: Attendee | null;
}
