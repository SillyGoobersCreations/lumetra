import {EventRoom} from "@/types/models/EventRoom";
import {EventRoomSlotClaim} from "@/types/models/EventRoomSlotClaim";

export interface EventRoomSlot {
    id: string;
    start_date: string;
    end_date: string;
    notes: string | null;
    state: string;
    created_at: Date | null;
    updated_at: Date | null;
    event_room_id: string;
    room: EventRoom | null;
    claims: EventRoomSlotClaim | null;
}
