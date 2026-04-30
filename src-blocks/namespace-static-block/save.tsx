import { useBlockProps } from "@wordpress/block-editor";
import { BlockSaveProps } from "@wordpress/blocks";
import { Attributes } from "./edit";

export default function Save({
    attributes,
}: BlockSaveProps<Attributes>) {
    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps}>
                <h1>This is rendered dynamically.</h1>
        </div>
    );
}
