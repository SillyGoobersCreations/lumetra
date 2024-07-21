import {Attendee} from "@/types/models/Attendee";
import {EventRoom} from "@/types/models/EventRoom";
import {EventNote} from "@/types/models/EventNote";
import {Swatch} from "@/types/models/Swatch";

export interface Event {
    id: string;
    title: string;
    state: string;
    logo: string | null;
    description: string | null;
    start_date: string | null;
    end_date: string | null;
    color_primary: string | null;
    confirmation_required: number;
    confirmation_personalized: number;
    room_slot_max_claims: number;
    room_slot_min_time: number;
    room_slot_max_time: number;
    room_slot_team_confirmation_required: number;
    attendees_max: number | null;
    created_at: Date | null;
    updated_at: Date | null;
    attendees: Attendee[];
    rooms: EventRoom[];
    notes: EventNote[];
    swatch: Swatch;
}
