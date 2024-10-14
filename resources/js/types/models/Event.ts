import {Attendee} from "@/types/models/Attendee";
import {EventRoom} from "@/types/models/EventRoom";
import {EventNote} from "@/types/models/EventNote";
import {Swatch} from "@/types/models/Swatch";

export interface Event {
    id: string;
    title: string;
    organizer: string;
    state: 'draft' | 'public' | 'hidden';
    logo: string | null;
    description: string | null;
    start_date: string | null;
    end_date: string | null;
    color_primary: string | null;
    confirmation_required: boolean;
    confirmation_personalized: boolean;
    confirmation_key: number | null;
    room_slot_max_pending: number | null;
    room_slot_max_claimed: number | null;
    room_slot_min_time: number;
    room_slot_max_time: number;
    room_slot_team_confirmation_required: boolean;
    enrollment_enabled: boolean;
    privacy_url: string | null;
    attendees_max: number | null;
    created_at: Date | null;
    updated_at: Date | null;
    attendees: Attendee[];
    rooms: EventRoom[];
    notes: EventNote[];
    swatch: Swatch;
    email_name: string | null;
    email_from: string | null;
}
