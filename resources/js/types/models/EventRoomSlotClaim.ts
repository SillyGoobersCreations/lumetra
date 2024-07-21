import {EventRoomSlot} from "@/types/models/EventRoomSlot";
import {Attendee} from "@/types/models/Attendee";

export interface EventRoomSlotClaim {
    id: string;
    state: string;
    created_at: Date | null;
    updated_at: Date | null;
    event_room_slot_id: string;
    inviter_attendee_id: string;
    invitee_attendee_id: string;
    slot: EventRoomSlot | null;
    inviter_attendee: Attendee | null;
    invitee_attendee: Attendee | null;
}
