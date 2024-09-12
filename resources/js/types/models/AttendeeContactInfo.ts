import {Attendee} from "@/types/models/Attendee";

export interface AttendeeContactInfo {
    id: string;
    type: string;
    value: string;
    visibility: string;
    created_at: Date | null;
    updated_at: Date | null;
    attendee_id: string;
    attendee: Attendee | null;
}
