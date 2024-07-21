import {User} from "@/types/models/User";
import {AttendeeContactInfo} from "@/types/models/AttendeeContactInfo";
import {Event} from "@/types/models/Event";

export interface Attendee {
    id: string;
    handle: string;
    first_name: string;
    last_name: string;
    avatar_url: string | null;
    confirmed: number;
    confirmation_key: string | null;
    description: string | null;
    job_company: string | null;
    job_position: string | null;
    role: string;
    created_at: Date | null;
    updated_at: Date | null;
    event_id: string;
    user_id: string;
    contact_infos: AttendeeContactInfo[];
    contact_infos_count: number | null;
    event: Event | null;
    user: User | null;
    active: number;
    name_full: string;
    name_initials: string;
}
