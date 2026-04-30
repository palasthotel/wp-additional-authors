import { useBlockProps } from "@wordpress/block-editor";
import { BlockEditProps } from "@wordpress/blocks";

type Attributes = {};

export default function Edit({
    attributes,
    setAttributes,
}: BlockEditProps<Attributes>) {
    const blockProps = useBlockProps({});

    return (
        <div {...blockProps}>
            <p>Author Archive Biography</p>
        </div>
    );
}
