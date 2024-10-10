import {Attendee} from "@/types/models/Attendee";

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    created_at: Date | null;
    updated_at: Date | null;
    is_admin: number;
    is_event_creator: number;
    attendees: Attendee[];
}
